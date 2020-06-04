<?php

namespace ClaimBundle\Controller;

use ClaimBundle\Entity\Employee;
use ClaimBundle\Form\ClaimType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClaimBundle\Entity\Claim;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;



class ClaimController extends Controller{


    /**
     * @Route("/search", name="search")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $search = $request->request->get('search');

            $datas = explode(" ", $search);

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder();
            $query
                ->select('p')
                ->from('ClaimBundle:Claim', 'p');
            $i = 0;
            foreach ($datas as $data) {
                $query
                    ->andWhere('p.status LIKE :data'.$i.' OR p.answer LIKE :data'.$i)
                    ->setParameter('data'.$i, '%'.$data.'%');
                $i++;
            }

            $results = $query->getQuery()->getResult();
        }

        return $this->render('ClaimBundle:Claim:list.html.twig', array(
            'results' => $results
        ));
    }


    public function indexAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $Claim = $em->getRepository(Claim::class)->findAll();
        $nbPending = 0;
        $nbClosed=0;
        $nbSolved=0;

        foreach($Claim as $claim) {
            if($claim->getStatus() == 'Pending'){
                $nbPending = $nbPending + 1;
            } elseif ($claim->getStatus() == 'Closed')
            {
                $nbClosed= $nbClosed + 1;
            }else{
                $nbSolved= $nbSolved + 1;
            }
        }
        $data= array();
        $stat=['status', 'count'];
        array_push($data,$stat);
            $stat=array();
            array_push($stat,'Pending',$nbPending);
            array_push($stat,'Closed',$nbClosed);
            array_push($stat,'Solved',$nbSolved);
            $statPend=['Pending',$nbPending];
            $statClosed=['Closed',$nbClosed];
            $statSolved=['Solved',$nbSolved];
            array_push($data,$statPend);
            array_push($data,$statClosed);
            array_push($data,$statSolved);

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('The Stat of the Status of your Claims');
        $pieChart->getOptions()->setHeight(600);
        $pieChart->getOptions()->setWidth(1300);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
       // $pieChart->getOptions()->getTitleTextStyle()->setColor('#ffffff');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
       // $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
      //  $pieChart->getOptions()->setBackgroundColor('#1b1e21');
       // $pieChart->getOptions()->getLegend()->getTextStyle()->setColor("#ffffff");




        return $this->render('@Claim\Claim\stat.html.twig', array('piechart' => $pieChart));
    }




public function profileAction()
{
    return $this->render("@Claim/Claim/profile.html.twig");

}

    public function rateAction()
    {
        return $this->render("@Claim/Claim/rate.html.twig");

    }
    public function readAction()
{
    $listc=$this->getDoctrine()->getRepository(Claim::class)->findAll();
    return $this->render('@Claim/Claim/list.html.twig', array('listc'=>$listc));
}

        public function empAction()
    {
        $liste=$this->getDoctrine()->getRepository(Employee::class)->findAll();
        return $this->render('@Claim/Claim/emp.html.twig', array('liste'=>$liste));
    }

    public function adminAction()
    {
        return $this->render("@Claim/Claim/admin.html.twig");
    }
    public function listAction()
    {
        return $this->render("@Claim/Claim/list.html.twig");
    }


    public function frontAction(){
        return $this->render("@Claim/Claim/home.html.twig");

    }
    public function claimAction()
    {
        return $this->render("@Claim/Claim/claim.html.twig");
    }
    public function showAction()
    {
        $Claim=$this->getDoctrine()->getRepository(Claim::class)->findAll();
        return $this->render('@Claim\Claim\claim.html.twig', array('Claim'=>$Claim));
    }


    public function ajouterAction(Request $request)
    { $em = $this->getDoctrine()->getManager();
        $Claim = new Claim();
        $formClaim = $this->createForm(ClaimType::class, $Claim);
        $formClaim->handleRequest($request);
        if ($formClaim->isSubmitted())
        {
            $Claim->setStatus('Pending');
            $Claim->setAnswer('Waite please');
            $Claim->setId($this->getUser());
            $em->persist($Claim);
            $em->flush();

            return $this->redirectToRoute("claim_affiche");

        }

        return $this->render("@Claim/Claim/ajouter.html.twig", array('formClaim' => $formClaim->createView()));
    }

    public function answerAction( Request $request , $idrec)
    {

        $Claim = new Claim();
        $Claim=$this->getDoctrine()->getRepository(Claim::class)->find($idrec);
        //$formC = $this->createForm(ClaimType::class, $Claim);
         $formC  = $this->createFormBuilder($Claim)
            ->add('answer', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
             ->add('status', ChoiceType::class, [
                'choices' => [
                    "Pending"=>"Pending",
                    "Solved"=>"Solved",
                    "Closed"=>"Closed"
                ]
            ])->getForm();

        $formC->handleRequest($request);
        if ($formC->isSubmitted())

        {
            $em = $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("read_claim");

        }

        return $this->render("@Claim/Claim/response.html.twig", array('formC' => $formC->createView()));
    }


    public function deleteAction(Claim $Claim)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($Claim);
        $em->flush();
        return $this->redirectToRoute('claim_affiche');


    }
    public function suppAction(Claim $Claim)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($Claim);
        $em->flush();
        return $this->redirectToRoute('read_claim');


    }

}
