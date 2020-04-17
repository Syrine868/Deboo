<?php

namespace ClaimBundle\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="idOrder", type="integer", nullable=false)
     */
    private $idorder;

    /**
     * @var integer
     *
     * @ORM\Column(name="idProduct", type="integer", nullable=false)
     */
    private $idproduct;


}

