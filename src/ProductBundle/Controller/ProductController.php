<?php

namespace ProductBundle\Controller;
use MyBundle\Entity\Category;
use ProductBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Knp\Snappy\Pdf;
use Symfony\Component\Form\Form;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

use MyBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Tests\Fixtures\ToString;


class ProductController extends Controller
{
    public function addproductAction(Request $request)
    {
        $category = new Product();

        $form = $this->createForm(ProductType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($category);

            $entityManager->flush();
            $nomproduit=$category->getProductname();
            $prix=$category->getProductprice();


            $basic  = new \Nexmo\Client\Credentials\Basic('176e6155', 'DtarC4Wk7Ki4hobP');
            $client = new \Nexmo\Client($basic);

            $message = $client->message()->send([
                'to' => '21658407458',
                'from' => 'DEBOO',
                'text' => 'Votre Livre:.'.$nomproduit .' au prix de '.$prix.'a éte ajouter avec succes'
            ]);

            return $this->redirectToRoute('showproduct');


        }

        return $this->render('@Product/Product/addproduct.html.twig', array('form'=> $form->createView()));
    }

    public function showproductAction(Request $request)
    {
        $em = $this->getDoctrine();
        $product=$em->getRepository(Product::class)->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator =$this->get('knp_paginator');
        $listproduct = $paginator->paginate(
            $product,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        /*$data= array();
        $stat=['category','product'];
        $nb=0;
        array_push($data,$stat);

        foreach ($product as $row)
        {
            $stat=array();
//            array_push($stat,$row->getPartenaire()->getNom(),(($row->getMontant())*100)/$montantTotal);
//            $nb=($row->getMontant()*100)/$montantTotal;

            array_push($stat,$row->getCategoryid()->getCategoryname(),$row->getProductname());

            $nb=$row->getProductname();

            $stat=[$row->getCategoryid()->getCategoryname(),$nb];
            array_push($data,$stat);
        }



        $pieChart = new PieChart();
       /* $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
            ]
        );*/
       /*$pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Publication poster par chaque Utilisateur');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(1125);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#00008B');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);*/
       /* $montantTotal=0;
        foreach ($liste as $row)
        {
            $montantTotal+=$row->getMontant();

        }

        $data= array();
        $stat=['inventaire','montant'];
        $nb=0;
        array_push($data,$stat);
        foreach ($liste as $row)
        {
            $stat=array();
//            array_push($stat,$row->getPartenaire()->getNom(),(($row->getMontant())*100)/$montantTotal);
//            $nb=($row->getMontant()*100)/$montantTotal;

            array_push($stat,$row->getPartenaire()->getNom(),$row->getMontant());

            $nb=$row->getMontant();

            $stat=[$row->getPartenaire()->getNom()." ".$row->getPartenaire()->getPrenom(),$nb];
            array_push($data,$stat);
        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Montant à payer par chaque partenaire');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(1125);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#f47684');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        $em1=$this->getDoctrine()->getRepository(Product::class)->findAll();*/

        return $this->render('@Product/Product/showproduct.html.twig', array('product'=>$listproduct));
    }
    public function frontshowproductAction(Request $request)
    {
        $em = $this->getDoctrine();

        $product=$em->getRepository(Product::class)->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator =$this->get('knp_paginator');
        $listproduct = $paginator->paginate(
            $product,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );





        return $this->render('@Product/Product/frontshow.html.twig', array('product'=>$listproduct
        ));
    }
    public function detailAction($idproduct)
    {
        $product=$this->getDoctrine()->getRepository(Product::class)->find($idproduct);

        return $this->render('@Product/Product/detailproduct.html.twig', array('product'=>$product));

    }
    public function deleteproductAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $v=$em->getRepository(Product::class)->find($request->get('idproduct'));
        $em->remove($v);
        $em->flush();
        return $this->redirectToRoute('showproduct');
    }


    public function sortAction($sort,Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        if ($sort=='ASC'){
            $query = $entityManager->createQuery(
                'SELECT p
    FROM MyBundle:product p
    ORDER BY p.productprice ASC'
            );
        }else {
            $query = $entityManager->createQuery(
                'SELECT p
    FROM MyBundle:product p
    ORDER BY p.productprice  DESC'
            );
        }



        $product = $query->getResult();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator =$this->get('knp_paginator');
        $listproduct = $paginator->paginate(
            $product,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3));

        return $this->render('@Product/Product/sort.html.twig', array('product'=>$listproduct));
    }


    public function editprodAction(Request $request,$idproduct)
    {

        $formation=$this->getDoctrine()->getRepository(Product::class)->find($idproduct);

        $form = $this->createForm(ProductType::class,$formation);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();




            $entityManager->flush();

            return $this->redirectToRoute('showproduct');

        }

        return $this->render('@Product/Product/editprod.html.twig', array('form'=> $form->createView()));

    }
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $prod = $em->getRepository('MyBundle:Product')->findEntitiesByString($requestString);
        if(!$prod)
        {
            $result['product']['error']="produit introuvable :( ";

        }else{
            $result['product']=$this->getRealEntities($prod);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($prod){
        foreach ($prod as $prod){
            $realEntities[$prod->getIdproduct()] = [$prod->getProductname(),$prod->getProductpic()];
        }
        return $realEntities;
    }

    public function pdfAction()
    {
        $date = new \DateTime('now');
        $produits = $this->getDoctrine()->getManager()->getRepository('MyBundle:Product')->findAll();
        $snappy = new Pdf('C:\wamp64\www\wkhtmltox\bin\wkhtmltopdf');
        $html="<style>

.clearfix:after {
  content: \"\";
  display: table;
  clear: both;
}

a {
  color: #001028;
  text-decoration: none;
}

body {
  font-family: Junge;
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-size: 14px; 
}

.arrow {
  margin-bottom: 4px;
}

.arrow.back {
  text-align: right;
}

.inner-arrow {
  padding-right: 10px;
  height: 30px;
  display: inline-block;
  background-color: rgb(233, 125, 49);
  text-align: center;

  line-height: 30px;
  vertical-align: middle;
}

.arrow.back .inner-arrow {
  background-color: rgb(233, 217, 49);
  padding-right: 0;
  padding-left: 10px;
}

.arrow:before,
.arrow:after {
  content:'';
  display: inline-block;
  width: 0; height: 0;
  border: 15px solid transparent;
  vertical-align: middle;
}

.arrow:before {
  border-top-color: rgb(233, 125, 49);
  border-bottom-color: rgb(233, 125, 49);
  border-right-color: rgb(233, 125, 49);
}

.arrow.back:before {
  border-top-color: transparent;
  border-bottom-color: transparent;
  border-right-color: rgb(233, 217, 49);
  border-left-color: transparent;
}

.arrow:after {
  border-left-color: rgb(233, 125, 49);
}

.arrow.back:after {
  border-left-color: rgb(233, 217, 49);
  border-top-color: rgb(233, 217, 49);
  border-bottom-color: rgb(233, 217, 49);
  border-right-color: transparent;
}

.arrow span { 
  display: inline-block;
  width: 80px; 
  margin-right: 20px;
  text-align: right; 
}

.arrow.back span { 
  margin-right: 0;
  margin-left: 20px;
  text-align: left; 
}

h1 {
  color: #5D6975;
  font-family: Junge;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  border-top: 1px solid #5D6975;
  border-bottom: 1px solid #5D6975;
  margin: 0 0 2em 0;
}

h1 small { 
  font-size: 0.45em;
  line-height: 1.5em;
  float: left;
} 

h1 small:last-child { 
  float: right;
} 

#project { 
  float: left; 
}

#company { 
  float: right; 
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 30px;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.sub {
  border-top: 1px solid #C1CED9;
}

table td.grand {
  border-top: 1px solid #5D6975;
}

table tr:nth-child(2n-1) td {
  background: #EEEEEE;
}

table tr:last-child td {
  background: #DDDDDD;
}

#details {
  margin-bottom: 30px;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}</style>
<h1>Product List</h1>
 <!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <title>Example 3</title>
    <link rel=\"stylesheet\" href=\"style.css\" media=\"all\" />
  </head>
  <body>
    <main>
      <h1  class=\"clearfix\"><small><span>DATE</span><br />".$date->format("Y-m-d")."
      <table>
        <thead>
          <tr><th class=\"service\">NOM Du Produit</th>
          <th>Categoryname</th>
            <th>PRICE</th>
            
          </tr>
        </thead><tbody>
";

        foreach ($produits as $e){


            $html=$html."<tr>
            <td class=\"service\">". $e->getProductname()."</td>
           <td class=\"unit\">". $e->getCategoryid()->getCategoryname()."</td>
            <td class=\"unit\">". $e->getProductprice()."</td>
         
          </tr>";
        }
        $html=$html." </tbody>
      </table>
      <div id=\"details\" class=\"clearfix\">
        <div id=\"project\">
          <div class=\"arrow\"><div class=\"inner-arrow\"><span>COMPANY</span>Deboo</div></div>
          <div class=\"arrow\"><div class=\"inner-arrow\"><span>(216)20009000</span> PHONE</div></div>
          </div>
        <div id=\"company\">
          <div class=\"arrow back\"><div class=\"inner-arrow\">Ariana soghra<span>ADDRESS</span></div></div>
          <div class=\"arrow back\"><div class=\"inner-arrow\">EMAIL<span>Deboo@esprit.com</span></div></div>
           </div>
      </div>
      <div id=\"notices\">
        <div>NOTICE:</div>
        <div class=\"notice\">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
     Hunt Kingdom
    </footer>
  </body>
</html>";
        $snappy->generateFromHtml($html, 'C:\wamp64\www\deboo\pdf'.$date->format("Y/m/d/Hi").'min.pdf');


        return $this->redirectToRoute('showproduct');
    }


}
