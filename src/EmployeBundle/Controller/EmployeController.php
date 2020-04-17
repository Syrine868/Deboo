<?php

namespace EmployeBundle\Controller;


use EmployeBundle\Entity\Absence;
use EmployeBundle\Form\AbsenceType;
use EmployeBundle\Form\EmployeeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EmployeBundle\Entity\Employee;
use Swift_Message;
use EmployeBundle\Entity\Mail;
use EmployeBundle\Form\MailType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @link http://fullcalendar.io/docs/event_data/events_json_feed/
 *
 * @param Request $request
 *
 * @return Response
 */
class EmployeController extends Controller
{

    public function calculerNbrAbsenceParEmployeAction(Employee $employee)
    {
        $absences=$this->getDoctrine()->getManager()->getRepository(Absence::class)->findBy(['idemp'=>$employee->getIdemp()]);

        foreach ($absences as $item)

            if($item == $employee->getIdemp())
            {   $selectAll= $this->getDoctrine()->getManager();
                $nbab= $employee->getNbabs();
                $employee->setNbabs($nbab+1);
                $selectAll->flush();
            }


    }
    public function showAction(Employee $e= null)
    {
        if(!$e)
        {
            $e = new Employee();
        }
       /* $this->sendMailAutoAction($e);*/
        $this->calculerNbrAbsenceParEmployeAction($e);
        $employe = $this->getDoctrine()->getRepository(Employee::class)->findAll();

     return $this->render('@Employe/Employes/employe.html.twig',array('liste' => $employe));
    }


    public function addAction(Request $request, Employee $employee = null)
    {
        if (!$employee) {
            $employee = new Employee();
        }
//test est ce que employye fyh valeur wale , ken ey yaamel update ken le yajouti

        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();
            return $this->redirectToRoute('list_empployees');
        }
        return $this->render('@Employe/Employes/ajoutEmploye.html.twig', ['formEmp' => $form->createView(), 'editMode' => $employee->getIdemp() != null]);
    }


    public function indexAction()
    {

        return $this->render('@Employe\Employes\home.html.twig');
    }
    public function indexfAction()
    {

        return $this->render('@Employe\Employes\front.html.twig');
    }

    public function equipeshowAction()
    {

        return $this->render('@Employe\Employes\equipe.html.twig');
    }
   /* public function indexxAction()
    {
        return $this->render('@Employe\Employes\ajoutAbsence.html.twig');

    }*/

    public function removeAction(Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($employee);
        $em->flush();
        return $this->redirectToRoute('list_empployees');
    }

////Absence\\\\
    public function addabAction(Request $request, Absence $absence = null)
    {
        if (!$absence) {
            $absence = new Absence();
        }
        //test est ce que employye fyh valeur wale , ken ey yaamel update ken le yajouti

        $form = $this->createForm(AbsenceType::class, $absence);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($absence);
            $em->flush();
            return $this->redirectToRoute('absence_listpage');
        }
        return $this->render('@Employe/Absence/ajoutAbsence.html.twig', ['formAb' => $form->createView(), 'editMode' => $absence->getIdabsence() != null]);
    }

    public function showabAction()
    {
        $Absence = $this->getDoctrine()->getRepository(Absence::class)->findAll();
        return $this->render('@Employe/Absence/listAbsence.html.twig', array('liste' => $Absence));
    }


    public function removeabAction(Absence $absence)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('absence_listpage');
    }

    /*  public function calculateAction(Employee $employee , Absence $absence){
       $absence
      }*/
    public function searchAction()
    {
        $request = $this->getRequest();
        $data = $request->request->get('search');


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM EmployeBundle:Absence p
    WHERE p.idemp.firstnameemp LIKE :data ')
            ->setParameter('data', $data);


        $res = $query->getResult();

        return $this->render('EmployeBundle:Absence:listAbsence.html.twig', array(
            'res' => $res));
    }
    public function showequipeAction()
    {
        $employe = $this->getDoctrine()->getRepository(Employee::class)->findAll();
        return $this->render('@Employe/Employes/equipe.html.twig', array('liste' => $employe));
    }

    public function loginAction(){
        if ($this->isGranted('ROLE_ADMIN'))
        {
            return $this->render('@Employe/Employes/home.html.twig');
        }
        else
        {
            return $this->render('@Employe/Employes/front.html.twig');
        }

    }

    public function sendMailAction(Request $request , Employee $employee) {
        $mail = new Mail();
        $form= $this->createForm(MailType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid() && $form->isSubmitted()) {
            $subject = $mail->getSubject();
            $to=$employee->getEmailaddress();
            $object= $mail->getObject();
//$request->get('from')['object']
            $username='merai.nesrine@gmail.com';
            $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($to)
                ->setBody($object);
            $this->get('mailer')->send($message);
            return $this->redirectToRoute('list_empployees');

        }

        return $this->render('@Employe/Employes/new.html.twig', array(
             'from' => $form->createView()
         ));

    }


    public function loadAction()
    {

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $em= $this->getDoctrine()->getManager();
        $events =$em->getRepository('EmployeBundle:Absence')->findAll();
        foreach($events as $row)
        {
            $data[] = array(
                "id"   => $row->getIdAbsence(),
                'title'   => $row->getIdemp()->getFirstnameemp() ,
                'start'   => $row->getDate()->format('Y-m-d H:i:s'),
                'end'   => $row->getDate()->format('Y-m-d H:i:s')
            );
        }
        $jsonContent = $serializer->serialize($data, 'json');
        //  echo $jsonContent;
        $response = new Response();
        $response = new Response(json_encode($data));

      $response->headers->set('Content-Type', 'application/json');

        //echo $response;
        //echo ('******************************');
        //echo($jsonContent);
        // echo ('******************************');
        // dump($response);exit;
        return $response;

    }
    public function sendMailAutoAction( Employee $employee) {

            $subject = 'Absence';
            $to=$employee->getEmailaddress();
            $object= 'Vous avez depasser le nombre d absence veuillez justifier votre absence au pres de service RH';
            $username='merai.nesrine@gmail.com';
            $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($to)
                ->setBody($object);
            if ($employee->getNbabs()>0)
            { $this->get('mailer')->send($message);}


        }

       }
