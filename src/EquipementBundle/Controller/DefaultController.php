<?php

namespace EquipementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user= $this->getUser();

        return $this->render('@Equipement/Default/dash.html.twig',array('user'=>$user));
    }
}
