<?php

namespace EquipementBundle\Controller;

use EquipementBundle\Entity\Equipment;
use EquipementBundle\Form\EquipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EquipementController extends Controller
{

  public function addEquipmentAction(Request $request,Equipment $equipment=null){


        if(!$equipment) {
            $equipment=new Equipment();
        }
          $db=$this->getDoctrine()->getManager();
          $form=$this->createForm(EquipmentType::class,$equipment);
         $form=$form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($equipment);
            $em->flush();
            return $this->redirectToRoute('list_equipments');
         }
     return $this->render('@Equipement/EquipmentsViews/Add_equip.html.twig',array('form'=>$form->createView(),'editMode'=>$equipment->getIdequipment() !=null));
  }
  public function listEquipmentsAction(Request $request){
      $em= $this->getDoctrine()->getManager();
      $list_eq=$em->getRepository(Equipment::class)->findAll();
      return $this->render('@Equipement/EquipmentsViews/list_equipments.html.twig',array('eq'=>$list_eq));
  }
    public function readAction(){
        $doc=$this->getDoctrine()->getRepository(Equipment::class)->findAll();
        return $this->render('@Equipement/EquipmentsViews/list_equipments.html.twig',array('eq'=>$doc));
    }
    public function deleteEquipAction($idequipment)
    {
        $equipement = $this->getDoctrine()->getRepository(Equipment::class)->find($idequipment);
        $em= $this->getDoctrine()->getManager();
        $em->remove($equipement);
        $em->flush();
        return $this->redirectToRoute('list_equipments');
    }


}
