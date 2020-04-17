<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use ProductBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use MyBundle\Entity\Product;

class CategoryController extends Controller
{
    public function addAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($category);

            $entityManager->flush();
            return $this->redirectToRoute('showcategory');


        }

        return $this->render('@Product/Category/addcategory.html.twig', array('form'=> $form->createView()));
    }
    public function deleteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $v=$em->getRepository(Category::class)->find($request->get('idcategory'));
        $em->remove($v);
        $em->flush();
        return $this->redirectToRoute('showcategory');
    }

    public function showAction(Request $request)
    {
        $em = $this->getDoctrine();
        $category=$em->getRepository(Category::class)->findAll();

        return $this->render('@Product/Category/showcategory.html.twig', array('category'=>$category));
    }
    public function editAction(Request $request,$idcategory)
    {

        $category=$this->getDoctrine()->getRepository(Category::class)->find($idcategory);

        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();




            $entityManager->flush();

            return $this->redirectToRoute('showcategory');

        }

        return $this->render('@Product/Category/editcategory.html.twig', array('form'=> $form->createView()));

    }

}
