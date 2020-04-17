<?php

namespace EmployeBundle\Entity;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;

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
    private $idemp;

    /**
     * Absence constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdabsence()
    {
        return $this->idabsence;
    }

    /**
     * @param int $idabsence
     * @return Absence
     */
    public function setIdabsence(int $idabsence): Absence
    {
        $this->idabsence = $idabsence;
        return $this;
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
     * @return Absence
     */
    public function setDate(\DateTime $date): Absence
    {
        $this->date = $date;
        return $this;
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
     * @return \Employee
     */
    public function setIdemp( $idemp)
    {
        return $this->idemp = $idemp;

    }


    /**
     * @inheritDoc
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}

