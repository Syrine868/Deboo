<?php

namespace AchatBundle\Controller;

use AchatBundle\Entity\Category;
use AchatBundle\Entity\Commande;
use AchatBundle\Entity\Employee;
use AchatBundle\Entity\OrderLine;
use AchatBundle\Form\CommandeType;
use AchatBundle\Form\ResetCommandeType;
use MyBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Stripe\Stripe;



class AchatController extends Controller
{
    public function afficherProduitsAction(Request $request)
    {
        // $manager=$this->getDoctrine()->getManager();
        $produits=$this->getDoctrine()->getRepository(Product::class)->findAll();
        $categories=$this->getDoctrine()->getRepository(Category::class)->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('@Achat/Achat/produits.html.twig',['pagination'=>$pagination,'produits'=>$produits,'categories'=>$categories]);
    }

    public function rechercheAction(Request $request)
    {
        //$product= new Product();
        /*$form=$this->createForm(RechercheProduitType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $formations=$this->getDoctrine()->getRepository(Product::class)->findBy(array('productName'=>$product->getProductname()));
        }
        else
        {
            $formations=$this->getDoctrine()->getRepository(Product::class)->findAll();
        }
        return $this->render('@Achat/Achat/produit.html.twig', array ('form'=> $form->createView()));*/

    }




    public function ajouterProduitPanierAction(SessionInterface $session, $idProduct)
    {
        // $idProduct= $request->query->get('idProduct');

        $panier = $session->get('panier', []);
        $prod=$this->getDoctrine()->getRepository(Product::class)->find($idProduct);
        if(array_key_exists($idProduct,$panier)) { $panier[$idProduct]+=1; }
        else
        {
            $panier[$idProduct]=1;
        }
        $session->set('panier',$panier);
        $this->addFlash('success','Produit ajouté au panier');
        return $this->redirectToRoute('achat_produits');

    }

    public function getPanierAction(SessionInterface $session, Request $request)
    {
        $prods=[];
        $qts=[];
        $panier = $session->get('panier', []);
        $total=0;
        foreach ($panier as $id => $qte)
        {
            $prod=$this->getDoctrine()->getRepository(Product::class)->find($id);
            array_push($prods,$prod);
            array_push($qts,$qte);
            $total+=$qte*$prod->getProductprice();
        }
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande );
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $employee= new Employee();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $commande->setIdemp($employee->getIdemp());
            $commande->setClient($usr);
            $commande->setTotal(0);
            $entityManager->flush();
            foreach ($panier as $id => $qte){
                $line= new OrderLine();
                $prod=$this->getDoctrine()->getRepository(Product::class)->find($id);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($line);
                $line->setIdproduct($prod);
                $line->setIdorder($commande);
                $line->setQuantity($qte);
                $entityManager->flush();

            }
            $entityManager->persist($commande);
            $commande->setTotal($total);
            $entityManager->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('panier_afficher');

        }

        $paginator = $this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $prods,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('@Achat/Achat/panier.html.twig', [
            'prods' => $prods,
            'total' => $total,
            'qts' => $qts,
            'form' => $form->createView(),
            'pagination'=>$pagination
        ]);

    }

    public function supprimerProduitPanierAction($idProduct, SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        if(!empty($panier[$idProduct]))
            unset($panier[$idProduct]);
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_afficher');
    }

    public function updateQuantityPlusAction($idProduct, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

        if(array_key_exists($idProduct,$panier)) { $panier[$idProduct]+=1; }
        if($panier[$idProduct]==0){unset($panier[$idProduct]);}
        $session->set('panier',$panier);
        return $this->redirectToRoute('panier_afficher');

    }

    public function updateQuantityMoinsAction($idProduct, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

        if(array_key_exists($idProduct,$panier)) { $panier[$idProduct]=$panier[$idProduct]-1; }
        if($panier[$idProduct]==0){
            unset($panier[$idProduct]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('panier_afficher');

    }


    public function validerPaiementAction()
    {

        \Stripe\Stripe::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2');

        $charge = \Stripe\Charge::create(

            array(
                'amount' =>  2000,
                'currency' => 'eur',
                'source' => 'tok_visa',
                "description"=> "Paiement commande"
            ));


        return $this->render('@Achat/Stripe/paiement.html.twig');


    }

    public function validerCommandeAction(\FOS\UserBundle\Model\User $user)
    {
        $emp= $this->getDoctrine()->getManager();

        $em=$this->getDoctrine()->getManager();

        $panier= $this->getDoctrine()->getRepository(Commande::class)->findAll();
        $panier= new Commande();
        $panier->setOrderstate('confirmee');
        $panier->setTransporterchoicedate(new \DateTime('now'));
        $panier->setTotal(0);
        $panier->setId($user->getId());
        $panier->setOrderdate(new \DateTime('now'));
        $panier->setTransporterstate('en attente');
        $panier->setPaymentstate('carte bancaire');
        $em->persist($emp);
        $em->persist($panier);
        $em->flush();
        dump($panier);

        return $this->render('@Achat/Achat/success.html.twig',array('user'=>$user));
    }


    public function paymentAction(SessionInterface $session, Request $request, Employee $employee=null)
    {

        if(!$employee)
        {
            $employee= new Employee();
        }
        $prods=[];
        $qts=[];
        $panier = $session->get('panier', []);
        $total=0;
        foreach ($panier as $id => $qte)
        {
            $prod=$this->getDoctrine()->getRepository(Product::class)->find($id);
            array_push($prods,$prod);
            array_push($qts,$qte);
            $total+=$qte*$prod->getProductPrice();
        }
        $em = $this->getDoctrine()->getManager();
        $commande= new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $e=$this->getDoctrine()->getRepository(Employee::class)->find(2);
        // $o=$this->getDoctrine()->getRepository(Commande::class)->find(18);
        //   $employees= $this->getDoctrine()->getRepository(Employee::class)->findOneBy(array('idemp'=>$e->getIdEmp()));
        // $employees->findOneBy(array('idemp'=>$employee->getIdemp()));
        $commande->setId($user);
        $commande->setOrderstate('en attente de confirmation');
        $commande->setTotal($total);
        $commande->setOrderdate(new \DateTime('now'));
        $commande->setTransporterchoicedate(new \DateTime('now'));
        $commande->setPaymentstate('carte credit');
        $commande->setTransporterstate('non affecté');
        $commande->setIdemp($e);


        $em->persist($commande);
        $em->flush();
        // $comm = $session->get('commande', []);
        // $session->set('commande',$commande);
        // $comm = $em->getRepository('AchatBundle:Commande')->find($commande->getIdorder());


        //----------------------------------------------
        //--------------------------------------------

        // $line= new OrderLine();
        //$form1= $this->createForm(OrderLineType::class, $line);
        /*$form1->handleRequest($request);
        $line->setIdproduct($prods);
        $line->setIdorder($comm);
        $line->setQuantity($qts);
        $em->persist($line);*/

        \Stripe\Stripe::setApiKey('sk_test_6BoRQXIx89ypSbKukxn81sqQ00kFhWhVEq');
        \Stripe\Charge::create(
            array(
                'amount' =>$total * 3 ,
                'currency' => 'eur',
                'source' => 'tok_visa',
                'description'=>'Operation de paiement',
                //  'customer'=>Stripe::$clientId,
                ''=> $commande,

            ));
        $this->addFlash('success','Paiement confirmé , consulter votre compte stripe');
        return $this->render('@Achat/Achat/paiement.html.twig');
    }


    public function commandesClientAction(Request $request, $id)
    {
        // $user = $this->get('security.token_storage')->getToken()->getUser();
        //$usr= $this->getUser()->getUsername();
        $getUser= $this->getDoctrine()->getRepository(Commande::class)->findBy(['id'=>$id]);
        $paginator = $this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $getUser,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('@Achat/Commande/commandeRecente.html.twig',
            ['pagination'=>$pagination, 'getUser'=>$getUser]);
    }


    public function findcommandesClientAction(Request $request, Commande $commande)
    {
        // $user = $this->get('security.token_storage')->getToken()->getUser();
        //$usr= $this->getUser()->getUsername();
        $formfind= $this->createFormBuilder($commande)
            ->add('orderDate', DateType::class)
            ->getForm();
        $formfind->handleRequest($request);
        if($formfind->isSubmitted())
        {
            $getUserId= $this->getDoctrine()->getRepository(Commande::class)
                ->findOneBy(array('orderDate'=> $commande->getOrderdate()));
            return $this->addFlash('success','Commande trouvée');
        }
        else
        {
            $getUserId= $this->getDoctrine()->getRepository(Commande::class)->findAll();
            return $this->addFlash('error','Commande non trouvée');
        }


        return $this->render('@Achat/Commande/commandeRecente.html.twig',
            ['getUserId'=>$getUserId,'formfind'=>$formfind->createView()]);
    }


    public function annulerCommandeAction(Request $request, $idOrder)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        // $idOrder= $request->request->get('idOrder');
        $getCommande=$this->getDoctrine()->getRepository(Commande::class)->find($idOrder);
        $form = $this->createForm(ResetCommandeType::class, $getCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($getCommande);
            $em->flush();

            $this->addFlash('success','Commande annulée , veuillez consulter de nouveau votre liste de commandes ...');
        }



        //return $this->redirectToRoute('all_comd_client');
        return $this->render('@Achat/Commande/resetCommande.html.twig', [
            'form' => $form->createView(),
            'idOrder'=>$idOrder,
            'user'=>$this->getUser(),
            'getCommande'=>$getCommande,
        ]);
    }

    public function deleteCommandeAction($idOrder)
    {
        $commande=$this->getDoctrine()->getRepository(Commande::class)->find($idOrder);
        $em=$this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        return $this->generateUrl('all_comd_client');
        //return $this->redirectToRoute('all_comd_client');
    }

    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString=$request->get('c');
        $commandes=$em->getRepository('AchatBundle:Commande')->findEntitiesByString($requestString);
        if($commandes)
            $result['commandes']['error']='Commande non trouvée';
        $result['commandes']=$this->getRealEntities($commandes);

        return new Response(json_encode($result));

    }

    public function getRealEntities($commandes)
    {
        foreach ($commandes as $commandes)
        {
            $realEntities[$commandes->getIdorder()]=[$commandes->getOrderdate(),
                $commandes->getOrderstate(),
                $commandes->getPaymentstate()];
        }

        return $realEntities;
    }




}
