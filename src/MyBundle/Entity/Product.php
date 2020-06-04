<?php

namespace MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="idCategory", columns={"categoryId"})})
 * @ORM\Entity(repositoryClass="MyBundle\Repository\UserRepository")
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @var string
     *
     * @ORM\Column(name="productName", type="string", length=20, nullable=true)
     */
    private $productname;

    /**
     * @var float
     *
     * @ORM\Column(name="productPrice", type="float", precision=10, scale=0, nullable=true)
     */
    protected $productprice;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="categoryid", referencedColumnName="idCategory")
     * })
     */
    private $categoryid;

    /**
     * @var string
     *
     * @ORM\Column(name="productpic", type="string", length=255, nullable=true)
     */
    private $productpic;

    /**
     * @var integer
     *
     * @ORM\Column(name="idProduct", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduct;



    /**
     * Set productname
     *
     * @param string $productname
     *
     * @return Product
     */
    public function setProductname($productname)
    {
        $this->productname = $productname;

        return $this;
    }

    /**
     * Get productname
     *
     * @return string
     */
    public function getProductname()
    {
        return $this->productname;
    }

    /**
     * Set productprice
     *
     * @param float $productprice
     *
     * @return Product
     */
    public function setProductprice($productprice)
    {
        $this->productprice = $productprice;

        return $this;
    }

    /**
     * Get productprice
     *
     * @return float
     */
    public function getProductprice()
    {
        return $this->productprice;
    }

    /**
     * Set categoryid
     *
     * @param integer $categoryid
     *
     * @return Product
     */
    public function setCategoryid($categoryid)
    {
        $this->categoryid = $categoryid;

        return $this;
    }

    /**
     * Get categoryid
     *
     * @return integer
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * Set productpic
     *
     * @param string $productpic
     *
     * @return Product
     */
    public function setProductpic($productpic)
    {
        $this->productpic = $productpic;

        return $this;
    }

    /**
     * Get productpic
     *
     * @return string
     */
    public function getProductpic()
    {
        return $this->productpic;
    }

    /**
     * Get idproduct
     *
     * @return integer
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }
    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="productpic")
     *
     * @var File
     */
    private $imageFile;


    public function setImageFile(File $productpic = null)
    {
        $this->imageFile = $productpic;
        if ($productpic) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

}
