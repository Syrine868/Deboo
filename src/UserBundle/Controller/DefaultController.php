<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
            if ($this->isGranted('ROLE_ADMIN'))
            {
                return $this->render('@User/Default/index.html.twig');
            }
            else
            {
               return $this->render('@User/front/front.html.twig');
            }
    }


    public function profileUserAction(){
       return $this->render('@User/Front/profileUser.html.twig');
    }

    public function editprofileUserAction(){

        return $this->render('@User/Front/editprofileUser.html.twig');
    }


}
