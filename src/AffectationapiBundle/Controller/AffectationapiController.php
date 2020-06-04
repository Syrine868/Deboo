<?php

namespace AffectationapiBundle\Controller;

use ClaimBundle\Entity\Claim;
use EmployeBundle\Entity\Absence;
use EmployeBundle\Entity\Employee;
use FaqsBundle\Entity\Question;
use FaqsBundle\Entity\Reponse;
use MyBundle\Entity\Category;
use MyBundle\Entity\Product;
use UserBundle\Entity\User;
use FaqsBundle\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AffectationapiController extends Controller
{
    public function listEquipmentsApiAction(){
        $em= $this->getDoctrine()->getManager();
        $list_eq=$em->getRepository('EquipementBundle:Equipment')->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($list_eq);
        return new JsonResponse($formatted);

    }
    public function allQuestionsUsersAction($id){
        $list_questions= $this->getDoctrine()->getRepository(Question::class)->findBy(['id'=>$id]);

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($list_questions);
        return new JsonResponse($formatted);
    }

    public function listQuestionAction(){
        $id= $this->getUser();
        $list_questions= $this->getDoctrine()->getRepository(Question::class)->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($list_questions);
        return new JsonResponse($formatted);
    }
    public function AddQuestionAction(Request $request,$id)
    {
        // $user=$this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $ques = new Question();
        $ques->setQuestionarea($request->get('questionArea'));
        $ques->setHeadline($request->get('headline'));
        $ques->setSlug($request->get('headline'));
        $ques->setId($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ques);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ques);
        return new JsonResponse($formatted);

    }

    public function testAction()
    {
        $tasks = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function loginAction()
    {
        return $this->json([
                'user' => $this->getUser() ? $this->getUser()->getId() : null]
        );
    }

    public function questionsAction(){
        // $list_faqs =$this->getDoctrine()->getRepository(Reponse::class)->findAll();
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository(Reponse::class)->findLogBy();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);
    }


    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setEnabled($request->get('enabled'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function updateAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function allClaimsAction()
    {
        $claims= $this->getDoctrine()->getManager()
            ->getRepository('ClaimBundle:Claim')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($claims);
        return new JsonResponse($formatted);
    }
    public function findClaimAction($idRec)
    {
        $claims = $this->getDoctrine()->getManager()
            ->getRepository('ClaimBundle:Claim')
            ->find($idRec);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($claims);
        return new JsonResponse($formatted);
    }
    public function newClaimAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $claims = new Claim();
        $claims->setMessage($request->get('message'));
        $claims->setStatus('Pending');
        $claims->setAnswer('Wait please');
        $claims->setId($request->get('id'));
        $em->persist($claims);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize( $claims);
        return new JsonResponse($formatted);
    }
    public function allAbsenceAction()
    {
        $absence = $this->getDoctrine()->getManager()
            ->getRepository('EmployeBundle:Absence')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($absence);
        return new JsonResponse($formatted);
    }
    public function newAbsenceAction(Request $request)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        //$cat = new  Category();
        //int $idcat;
        //$idcat->setIdCategory($cat);
        try {
            $date = new \DateTime($request->get('date'));
            $idemp = $request->get('idemp');
            $emp=$entitymanager->getRepository(Employee::class)->findOneBy(array("firstnameemp"=>$idemp));

        } catch (\Exception $e) {
        }
        $user = new Absence();
        $user->setDate($date);
        $user->setIdemp($emp);
        $entitymanager->persist($user);
        $entitymanager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function newEmployeeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $employes = new Employee();
        $employes->setLastnameemp($request->get('lastname'));
        $employes->setFirstnameemp($request->get('firstname'));
        $employes->setAge($request->get('age'));
        $employes->setPhone($request->get('phone'));
        $employes->setSalary($request->get('salary'));
        $employes->setEmailaddress($request->get('email'));
        $employes->setFonction($request->get('fonction'));
    }

    public function allEmployeesAction()
    {
        $employes = $this->getDoctrine()->getManager()
            ->getRepository('EmployeBundle:Employee')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($employes);
        return new JsonResponse($formatted);
    }

    public function showProduitsAction(Request $request)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('MyBundle:Product')->findLogByID();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);
    }
    public function showCategoryAction(Request $request)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('MyBundle:Category')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);
    }
    public function addProductAction(Request $request)
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $nom = $request->get('productname');
        $prix = $request->get('productprice');
        $catid = $request->get('categoryid');
        $pic = $request->get('productpic');
        //$cat = new  Category();
        $cat=$entitymanager->getRepository(Category::class)->findOneBy(array("categoryname"=>$catid));
        //int $idcat;
        //$idcat->setIdCategory($cat);
        $user = new Product();
        $user->setCategoryid($cat);
        $user->setProductname($nom);
        $user->setProductprice($prix);
        $user->setProductpic($pic);
        $entitymanager->persist($user);
        $entitymanager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

}
