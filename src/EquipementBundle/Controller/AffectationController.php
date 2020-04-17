<?php

namespace EquipementBundle\Controller;

use EquipementBundle\Entity\Assignment;
use EquipementBundle\Entity\Employee;
use EquipementBundle\Form\AssignmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AffectationController extends Controller
{

    public function listEmployeesAction(){
        $em= $this->getDoctrine()->getManager();
        $list_emp=$em->getRepository(Employee::class)->findAll();
        return $this->render('@Equipement/AffectationsViews/list_employees.html.twig',array('emp'=>$list_emp));

    }
    public function listAffectationsAction(){
        $em= $this->getDoctrine();
        $list_aff=$em->getRepository(Assignment::class)->findAll();
        return $this->render('@Equipement/AffectationsViews/list_affectations.html.twig',array('list_aff'=>$list_aff));
    }
    public function AddAffectationAction(Request $request, Assignment $ass=null){
        if(!$ass){
                 $ass = new Assignment();
        }
          $formAff= $this->createForm(AssignmentType::class, $ass);
         $formAff->handleRequest($request);
          if ($formAff->isSubmitted() && $formAff->isValid())
          {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ass);
            $em->flush();
            return $this->redirectToRoute('list_affectations');
         }
        return $this->render('@Equipement/AffectationsViews/Add_affectation.html.twig', array('formAff'=>$formAff->createView(),'edit'=>$ass->getId() != null));
    }
    public  function  deleteAffectationAction($id){
        $assignment = $this->getDoctrine()->getRepository(Assignment::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($assignment);
        $em->flush();
        return $this->redirectToRoute('list_affectations');
    }
    public function listNonAffectesAction(){
        $em= $this->getDoctrine();
        $list_aff=$em->getRepository(Assignment::class)->findAll();
        return $this->render('@Equipement/AffectationsViews/list_affectations.html.twig',array('list_aff'=>$list_aff));
    }
}
