<?php

namespace AchatBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderLine
 *
 * @ORM\Table(name="order_line", indexes={@ORM\Index(name="idOrder", columns={"idOrder"}), @ORM\Index(name="idProduct", columns={"idProduct"})})
 * @ORM\Entity
 */
class OrderLine
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idOrderLine", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idorderline;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProduct", referencedColumnName="idProduct")
     * })
     */
    protected $idproduct;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOrder", referencedColumnName="idOrder")
     * })
     */
    protected $idorder;

    /**
     * OrderLine constructor.
     */
    public function __construct()
    {
        $this->idorder=new ArrayCollection();
        $this->idproduct=new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdorderline()
    {
        return $this->idorderline;
    }

    /**
     * @param int $idorderline
     */
    public function setIdorderline($idorderline)
    {
        $this->idorderline = $idorderline;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return \Product
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }

    /**
     * @param \Product $idproduct
     */
    public function setIdproduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }

    /**
     * @return \Commande
     */
    public function getIdorder()
    {
        return $this->idorder;
    }

    /**
     * @param \Commande $idorder
     */
    public function setIdorder($idorder)
    {
        $this->idorder = $idorder;
    }

    public function __toString()
    {
        return "";
    }


}

