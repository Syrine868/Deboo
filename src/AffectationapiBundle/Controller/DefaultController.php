<?php

namespace AffectationapiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AffectationapiBundle:Default:index.html.twig');
    }
}
