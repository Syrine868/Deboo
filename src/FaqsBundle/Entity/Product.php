<?php

namespace FaqsBundle\Entity;

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


}

