<?php

namespace AchatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="idCategory", columns={"categoryId"})})
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProduct", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduct;

    /**
     * @var string
     *
     * @ORM\Column(name="productName", type="string", length=20, nullable=false)
     */
    private $productname;

    /**
     * @var float
     *
     * @ORM\Column(name="productPrice", type="float", precision=10, scale=0, nullable=false)
     */
    private $productprice;

    /**
     * @var string
     *
     * @ORM\Column(name="productpic", type="string", length=255, nullable=false)
     */
    private $productpic;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoryId", referencedColumnName="idCategory")
     * })
     */
    private $categoryid;

    /**
     * Product constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }

    /**
     * @param int $idproduct
     */
    public function setIdproduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }

    /**
     * @return string
     */
    public function getProductname()
    {
        return $this->productname;
    }

    /**
     * @param string $productname
     */
    public function setProductname($productname)
    {
        $this->productname = $productname;
    }

    /**
     * @return float
     */
    public function getProductprice()
    {
        return $this->productprice;
    }

    /**
     * @param float $productprice
     */
    public function setProductprice($productprice)
    {
        $this->productprice = $productprice;
    }

    /**
     * @return string
     */
    public function getProductpic()
    {
        return $this->productpic;
    }

    /**
     * @param string $productpic
     */
    public function setProductpic($productpic)
    {
        $this->productpic = $productpic;
    }

    /**
     * @return \Category
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * @param \Category $categoryid
     */
    public function setCategoryid($categoryid)
    {
        $this->categoryid = $categoryid;
    }

    public function __toString()
    {
        return "";
    }


}

