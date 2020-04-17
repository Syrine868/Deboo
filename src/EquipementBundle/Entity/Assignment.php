<?php

namespace EquipementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Assignment
 *
 * @ORM\Table(name="assignment", indexes={@ORM\Index(name="idEmp", columns={"idEmp"}), @ORM\Index(name="idEquipment", columns={"idEquipment"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"equipment"}, message="Equipement déjà affecté")

 */
class Assignment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Date
     * @Assert\Date
     * @Assert\NotBlank
     * @Assert\LessThan(propertyPath="dateR")

     * @ORM\Column(name="dateP", type="date", nullable=false)
     */
    private $datep;

    /**
     * @var \Date
     *@Assert\GreaterThan(propertyPath="dateP")
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(name="dateR", type="date", nullable=false)
     */
    private $dater;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="state", type="string", length=255, nullable=false)
     */
    private $state;

    /**
     * @var \Employee
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmp", referencedColumnName="idEmp")
     * })
     */
    private $employee;

    /**
     * @var \Equipment
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Equipment" )
     *
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEquipment", referencedColumnName="idEquipment", unique=true)
     * })
     */
    private $equipment;

    public  function __construct()
    {
        $this->equipment = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Date
     */
    public function getDatep()
    {
        return $this->datep;
    }

    /**
     * @param \Date $datep
     */
    public function setDatep($datep)
    {
        $this->datep = $datep;
    }

    /**
     * @return \Date
     */
    public function getDater()
    {
        return $this->dater;
    }

    /**
     * @param \Date $dater
     */
    public function setDater($dater)
    {
        $this->dater = $dater;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @return \Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param \Equipment $equipment
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * @return \Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \Employee $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }



}

