<?php

namespace FaqsBundle\Controller;


use FaqsBundle\Entity\Question;
use FaqsBundle\Entity\Reponse;
use FaqsBundle\Entity\User;
use FaqsBundle\Form\QuestionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class FaqsController extends Controller
{
    public function indexAction(){
        return $this->render('@Faqs/FaqsViews/faqsfront.html.twig');

    }

    public function aboutAction(){
        return $this->render('@Faqs/FaqsViews/about.html.twig');

    }

    public function listFrontAction(){
        $reps=$this->getDoctrine()->getRepository(Reponse::class)->findAll();
        return $this->render('@Faqs/FaqsViews/faqsfront.html.twig', array('reps'=>$reps));
    }

    public function questionsAction(Request $request){
        $list_faqs =$this->getDoctrine()->getRepository(Reponse::class)->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $list_faqs,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('@Faqs/FaqsViews/questions.html.twig', array('list_faqs'=>$list_faqs,'pagination'=>$pagination));
    }

    public function AddQuestionAction(Request $request, Question $ques =null  ){
          $id= $this->getUser();
          $ques = new Question();

          $getUser= $this->getDoctrine()->getRepository(Question::class)->findBy(array('id'=>$id));
          $formFaqs= $this->createForm(QuestionType::class, $ques);
         $formFaqs->handleRequest($request);
          if ($formFaqs->isSubmitted() && $formFaqs->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ques->setId($this->getUser());
            $em->persist($ques);
            $em->flush();
            return $this->redirectToRoute('list_questions_user');
        }
       return $this->render('@Faqs/FaqsViews/addQuestion.html.twig', array('formFaqs'=>$formFaqs->createView()));
    }

    public function listQuestionAction(Request $request){
        $id= $this->getUser();
        $list_questions= $this->getDoctrine()->getRepository(Question::class)->findBy(array('id'=>$id));
        $paginator = $this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $list_questions,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('@Faqs/FaqsViews/listquestions.html.twig', array('list_questions'=>$list_questions,'pagination'=>$pagination));
    }
}
