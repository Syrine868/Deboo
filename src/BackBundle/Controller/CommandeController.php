<?php

namespace BackBundle\Controller;

use AchatBundle\Entity\Commande;
use AchatBundle\Form\ResetCommandeType;
use BackBundle\Form\EditStateCommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends Controller
{
    public function commandesAction()
    {
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();

        return $this->render('@Back/Commande/index.html.twig',['commandes'=>$commandes]);
    }

    public function supprimerAction($idOrder)
    {
        $em=$this->getDoctrine()->getManager();
        $commande= $this->getDoctrine()->getRepository(Commande::class)->find($idOrder);
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('commandes');
    }
    public function updateCommandeAction($idOrder, Request $request)
    {
        $commande=$this->getDoctrine()->getRepository(Commande::class)->find($idOrder);
        $form=$this->createForm(EditStateCommandeType::class, $commande);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('commandes');
        }
        return $this->render('@Back/Commande/edit.html.twig', array('idOrder'=>$idOrder, 'form'=>$form->createView()));
    }
}
