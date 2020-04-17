<?php

namespace FaqsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="order", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="idEmp", columns={"idEmp"})})
 * @ORM\Entity
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idOrder", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idorder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="date", nullable=false)
     */
    private $orderdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transporterChoiceDate", type="date", nullable=false)
     */
    private $transporterchoicedate;

    /**
     * @var string
     *
     * @ORM\Column(name="orderState", type="string", length=255, nullable=false)
     */
    private $orderstate;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="transporterState", type="string", length=255, nullable=false)
     */
    private $transporterstate;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentState", type="string", length=255, nullable=false)
     */
    private $paymentstate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEmp", type="integer", nullable=false)
     */
    private $idemp;


}

