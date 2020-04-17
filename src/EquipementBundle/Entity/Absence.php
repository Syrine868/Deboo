<?php

namespace EquipementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence", indexes={@ORM\Index(name="idEmp", columns={"idEmp"})})
 * @ORM\Entity
 */
class Absence
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAbsence", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idabsence;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmp", referencedColumnName="idEmp")
     * })
     */
    private $employee;

    /**
     * @return int
     */
    public function getIdabsence()
    {
        return $this->idabsence;
    }

    /**
     * @param int $idabsence
     */
    public function setIdabsence($idabsence)
    {
        $this->idabsence = $idabsence;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

