<?php

namespace AchatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="idEmp", columns={"idEmp"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idOrder", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idorder;

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
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="AchatBundle\Entity\Employee", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmp", referencedColumnName="idEmp")
     * })
     */
    protected $idemp;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    protected $id;

    /**
     * Commande constructor.
     */
    public function __construct()
    {
    }



    /**
     * Commande constructor.
     */

    /**
     * @return int
     */
    public function getIdorder()
    {
        return $this->idorder;
    }

    /**
     * @param int $idorder
     */
    public function setIdorder($idorder)
    {
        $this->idorder = $idorder;
    }

    /**
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * @param \DateTime $orderdate
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;
    }

    /**
     * @return \DateTime
     */
    public function getTransporterchoicedate()
    {
        return $this->transporterchoicedate;
    }

    /**
     * @param \DateTime $transporterchoicedate
     */
    public function setTransporterchoicedate($transporterchoicedate)
    {
        $this->transporterchoicedate = $transporterchoicedate;
    }

    /**
     * @return string
     */
    public function getOrderstate()
    {
        return $this->orderstate;
    }

    /**
     * @param string $orderstate
     */
    public function setOrderstate($orderstate)
    {
        $this->orderstate = $orderstate;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getTransporterstate()
    {
        return $this->transporterstate;
    }

    /**
     * @param string $transporterstate
     */
    public function setTransporterstate($transporterstate)
    {
        $this->transporterstate = $transporterstate;
    }

    /**
     * @return string
     */
    public function getPaymentstate()
    {
        return $this->paymentstate;
    }

    /**
     * @param string $paymentstate
     */
    public function setPaymentstate($paymentstate)
    {
        $this->paymentstate = $paymentstate;
    }

    /**
     * @return \Employee
     */
    public function getIdemp()
    {
        return $this->idemp;
    }

    /**
     * @param \Employee $idemp
     */
    public function setIdemp($idemp)
    {
        $this->idemp = $idemp;
    }

    /**
     * @return \User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \User $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return "";
    }

}

