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
            $file = $employee->getPic();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $employee->setPic($filename);
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
            return $this->redirectToRoute('list_empployees');
        }
        return $this->render('@Employe/Absence/ajoutAbsence.html.twig', ['formAb' => $form->createView(), 'editMode' => $absence->getIdabsence() != null]);
    }

    public function showabAction()
    {
        $Absence = $this->getDoctrine()->getRepository(Absence::class)->findAll();

        return $this->render('@Employe/Absence/listAbsence.html.twig', array('liste' => $Absence ));
    }


    public function removeabAction(Absence $absence)
    {
        $em = $this->getDoctrine()->getManager();
        $empl=$absence->getIdemp();
   $employe = $this->getDoctrine()->getRepository(Employee::class)->find($empl);
        $nb=$employe->getNbAbs();
        $employe->setNbAbs($nb-1);
        $em->persist($employe);
        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('list_empployees');
    }

    /*  public function calculateAction(Employee $employee , Absence $absence){
       $absence
      }*/
   /* public function searchAction()
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
    }*/

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
    public function detailAction($idemp)
    {
        $employee=$this->getDoctrine()->getRepository(Employee::class)->find($idemp);
        $absence=$this->getDoctrine()->getRepository(Absence::class)->findBy(array('idemp' => $employee));

        return $this->render('@Employe/Employes/detailempa.html.twig', array('emp'=>$absence ));

    }
    public function detailsAction(Request $request,$id)
    {
        $employe = $this->getDoctrine()->getRepository(Employee::class)->find($id);

        $absence= new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nbr= $employe->getNbabs();
            $employe->setNbabs($nbr+1);
            $absence->setIdemp($employe);
            $em= $this->getDoctrine()->getManager();
            $em->persist($employe);
            $em->persist($absence);
            $em->flush();
            return $this->redirectToRoute('list_empployees');

        }
        //$this->sendMailAutoAction($e);
        return $this->render('@Employe/Employes/employedetails.html.twig',array('form' => $form->createView(), 'emp'=>$employe));
    }

    public function ExpoAction()
    {
       // $date = new \DateTime('now');

        $em = $this->getDoctrine()->getManager();
        $employe = $em->getRepository(Employee::class)->findAll();
        // ask the service for a excel object
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'B25B6E'),
                'size'  => 10,
                'name'  => 'Arial'
            ));

        $styleArray1 = array(
            'font'  => array(
                'bold'  => true,
                //  'color' => array('rgb' => 'ECA1AC'),
                'size'  => 9,
                'name'  => 'Arial'

            ),
        );


        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");

        $lignes = 2;
        $phpExcelObject->setActiveSheetIndex(0);
        foreach ($employe as $emp){
            $phpExcelObject->getActiveSheet()
                ->setCellValue('A1',"LastName")
                ->setCellValue('B1',"FirstName")
                ->setCellValue('C1',"Age")
                ->setCellValue('D1',"Phone")
                ->setCellValue('E1',"Salary")
                ->setCellValue('F1',"EmailAddress")
                ->setCellValue('G1',"Function")
                ->setCellValue('H1',"number of absences")
                ->setCellValue('A' . $lignes, $emp->getLastnameemp())
                ->setCellValue('B' . $lignes,$emp->getFirstnameemp())
                ->setCellValue('C' . $lignes,$emp->getAge())
                ->setCellValue('D' . $lignes,$emp->getPhone())
                ->setCellValue('E' . $lignes,$emp->getSalary())
                ->setCellValue('F' . $lignes,$emp->getEmailAddress())
                ->setCellValue('G' . $lignes,$emp->getFonction())
                ->setCellValue('H' . $lignes,$emp->getNbAbs());
            $lignes++;




        }

        $phpExcelObject->getActiveSheet()->setTitle('Employees');
        /* $phpExcelObject->getActiveSheet()->getCell('A1')->setValue('LastName');
         $phpExcelObject->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);*/
        $phpExcelObject->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
       // $phpExcelObject->getActiveSheet()->getStyle('A2:H19')->applyFromArray($styleArray1);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // The save method is documented in the official PHPExcel library
        $writer->save('C:\wamp64\www\Deboo\web\uploads\Excel\employes.xlsx');


        // Return a Symfony response (a view or something or this will thrown error !!!)
        return $this->redirectToRoute('list_empployees');

    }

    public function ImportAction(){
        $data = [];
      //  $appPath = $this->container->getParameter('kernel.root_dir');
        $file = realpath('C:\wamp64\www\Deboo\web\uploads\Excel\import.xlsx');

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($file);
        $sheet = $phpExcelObject->getActiveSheet()->toArray(null, true, true, true);

        $em = $this->getDoctrine()->getManager();
        $data['sheet'] = $sheet;
        //READ EXCEL FILE CONTENT
        foreach($sheet as $i=>$row) {
            if($i !== 1) {
                $employe = new Employee();

                $employe->setLastnameemp($row['A']);
                $employe->setFirstnameemp($row['B']);
                $employe->setAge($row['C']);
                $employe->setPhone($row['D']);
                $employe->setSalary($row['E']);
                $employe->setEmailaddress($row['F']);
                $employe->setFonction($row['G']);
                $employe->setNbAbs($row['H']);
                $employe->setPic($row['I']);

                //... and so on


                $em->persist($employe);
                $em->flush();
                //redirect appropriately

            }
        }
        $phpExcelObject->getActiveSheet()->setTitle('Employees');

        $data['obj'] = $phpExcelObject;
        return $this->redirectToRoute('list_empployees');

    }
       }
