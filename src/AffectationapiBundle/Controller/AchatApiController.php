<?php

namespace AffectationapiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AchatBundle\Entity\Commande;
use AchatBundle\Entity\Employee;
use AchatBundle\Entity\Product;
use AchatBundle\Form\CommandeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class AchatApiController extends Controller
{

    //ADD TO CART API METHOD
    public function addProductToCartAction(SessionInterface $session, $idProduct)
    {
        $panier = $session->get('panier', []);
        $prod=$this->getDoctrine()->getRepository(Product::class)->find($idProduct);
        if(array_key_exists($idProduct,$panier)) { $panier[$idProduct]+=1; }
        else
        {
            $panier[$idProduct]=1;
        }
        $session->set('panier',$panier);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);

    }
    //DISPLAY CART API METHOD
    public function showCartAction(SessionInterface $session, Request $request)
    {
        $prods = [];
        $qts = [];
        $panier = $session->get('panier', []);
        $total = 0;
        foreach ($panier as $id => $qte) {
            $prod = $this->getDoctrine()->getRepository(Product::class)->find($id);
            array_push($prods, $prod);
            array_push($qts, $qte);
            $total += $qte * $prod->getProductprice();
        }
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);
    }

    //DELETE PRODUCT FROM CART API METHOD
    public function deleteProductFromCartAction($idProduct, SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        if(!empty($panier[$idProduct]))
            unset($panier[$idProduct]);
        $session->set('panier', $panier);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);
    }

    //PAYMENT STRIPE API METHOD
    public function paymentAction(SessionInterface $session, Request $request, Employee $employee=null,$id)
    {
        if(!$employee)
        {
            $employee= new Employee();
        }
        $prods=[];
        $qts=[];
        $panier = $session->get('panier', []);
        $total=0;
        foreach ($panier as $idProduct => $qte)
        {
            $prod=$this->getDoctrine()->getRepository(Product::class)->find($idProduct);
            array_push($prods,$prod);
            array_push($qts,$qte);
            $total+=$qte*$prod->getProductprice();
        }
        $em = $this->getDoctrine()->getManager();
        $commande= new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        // $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $e=$this->getDoctrine()->getRepository(Employee::class)->find(2);
        $commande->setId($user);
        $commande->setOrderstate('en attente de confirmation');
        $commande->setTotal($total);
        try
        {
            $date = new \DateTime($request->get('orderdate'));

            $commande->setOrderdate($date);
            $dat = new \DateTime($request->get('transporterchoicedate'));

            $commande->setTransporterchoicedate($dat);
        }
        catch (\Exception $e)
        {
        }

        $commande->setPaymentstate('carte credit');
        $commande->setTransporterstate('non affecté');
        $commande->setIdemp($e);

        $em->persist($commande);
        $em->flush();

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
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);

        return new JsonResponse($formatted);
    }

    public function commandesClientAction(Request $request, $id)
    {

        $getUser= $this->getDoctrine()->getRepository(Commande::class)->findBy(['id'=>$id]);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($getUser);

        return new JsonResponse($formatted);
    }


}
