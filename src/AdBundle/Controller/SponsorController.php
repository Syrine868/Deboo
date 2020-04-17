<?php


namespace AdBundle\Controller;


use AdBundle\Entity\Sponsor;
use AdBundle\Form\AdType;
use AdBundle\Form\SponsorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SponsorController extends Controller
{


    public function read_SponsorAction()
    {
        //1.créer un objet doctrine
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Sponsor::class)->findAll();
        return $this->render('@Ad/Sponsor/read_Sponsor.html.twig', array(
            'ads'=>$tab
        ));
    }
    //use Symfony\Component\HttpFoundation\Request;

    public function create_SponsorAction(Request $request)
    {
        //1.a cration d'un objet vide
        $Ad = new Sponsor();
        //1.b création du form
        $form=$this->createForm(SponsorType::class, $Ad);
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
            return $this->redirectToRoute('read_Sponsor');
        }
        //1.c envoi du fom à l'utilisateur
        return $this->render('@Ad/Sponsor/create_Sponsor.html.twig', array(
            'form'=>$form->createView()
        ));

    }

    public function delete_SponsorAction($id)
    {   //1.a recu de notre objet selon id envoyé par l'user
        $em=$this->getDoctrine()->getManager();
        //1.a cration d'un objet vide
        $ad=$em->getRepository(Sponsor::class)->find($id);
        $em->remove($ad);
        $em->flush();
        return $this->redirectToRoute('read_Sponsor');
    }

    public function updateAction($id, Request $request)
    {   //1.a recu de notre objet selon id envoyé par l'user
        $em=$this->getDoctrine()->getManager();
        //1.a cration d'un objet vide
        $club=$em->getRepository(Sponsor::class)->find($id);
        //1.b création du form
        $form=$this->createForm(SponsorType::class, $club);
        //2.a récup des données
       $form=$form->handleRequest($request);
        //3.a test sur les données
        if($form->isValid()){
            $em->flush();
            //6. redirect to route
            return $this->redirectToRoute('read_Sponsor');
        }
        //1.c envoi du fom à l'utilisateur
        return $this->render('@Ad/Sponsor/update_Sponsor.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}