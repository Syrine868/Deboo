<?php

namespace AdBundle\Controller;

use AdBundle\Entity\Ad;
use AdBundle\Entity\Sponsor;
use AdBundle\Form\AdType;
use AdBundle\Form\SponsorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdController extends Controller
{

    public function readAction()
    {
        //1.créer un objet doctrine
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Ad::class)->findAll();
        return $this->render('@Ad/Ad/read.html.twig', array(
            'ads'=>$tab
        ));
    }
    //use Symfony\Component\HttpFoundation\Request;

    public function createAction(Request $request)
    {
        //1.a cration d'un objet vide
        $Ad = new Ad();
        //1.b création du form
        $form=$this->createForm(AdType::class, $Ad);
        //2.a récup des données
        $form=$form->handleRequest($request);
        //3.a test sur les données
        if($form->isValid()){
            //4.a création d'un objet doctrine
            $em=$this->getDoctrine()->getManager();
            //4.b persister les donnéer ds  ORM
            $em->persist($Ad);
            //5.b sauv les données ds la BD
            $em->flush();
            //6. redirect to route
            return $this->redirectToRoute('read_ad');
        }

        //1.c envoi du fom à l'utilisateur
        return $this->render('@Ad/Ad/create.html.twig', array(
            'form'=>$form->createView()
        ));

    }

    public function deleteAction($id)
    {   //1.a recu de notre objet selon id envoyé par l'user
        $em=$this->getDoctrine()->getManager();
        //1.a cration d'un objet vide
        $ad=$em->getRepository(Ad::class)->find($id);
        $em->remove($ad);
        $em->flush();
        return $this->redirectToRoute('read_ad');
    }

    public function updateAction($id, Request $request)
    {   //1.a recu de notre objet selon id envoyé par l'user
        $em=$this->getDoctrine()->getManager();
        //1.a cration d'un objet vide
        $club=$em->getRepository(Ad::class)->find($id);
        //1.b création du form
        $form=$this->createForm(AdType::class, $club);
        //2.a récup des données
        $form=$form->handleRequest($request);
        //3.a test sur les données
        if($form->isValid()){
            $em->flush();
            //6. redirect to route
            return $this->redirectToRoute('read_ad');
        }
        //1.c envoi du fom à l'utilisateur
        return $this->render('@Ad/Ad/create.html.twig', array(
            'form'=>$form->createView()
        ));
    }




public function ad_clickAction($id)
{
    $em=$this->getDoctrine();
    $a=$em->getRepository(Ad::class)->find($id);
    $a->setNbr($a->getNbr()+1);
    $em->getManager()->flush();
    return new Response();

}


    public function chartAction()

    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.titre,p.nbr
            FROM AdBundle\Entity\Ad p'
        );
        $tab= $query->getResult();

        return $this->render('@Ad/Ad/ChartAd.html.twig', array(
            'ads'=>$tab
        ));
    }


    public function BarAction()

    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $query = $entityManager->createQuery('SELECT p.Sponsor_name, COUNT(p.id) as total
            FROM AdBundle\Entity\Ad p
            GROUP BY p.Sponsor_name'
        );
        $tab= $query->getResult();

        return $this->render('@Ad/Ad/bar.html.twig', array(
            'tab'=>$tab
        ));
    }




}
