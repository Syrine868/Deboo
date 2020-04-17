<?php

namespace ClaimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating", indexes={@ORM\Index(name="FK_EMP_RAT", columns={"idEmp"})})
 * @ORM\Entity
 */
class Rating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var \Employee
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmp", referencedColumnName="idEmp")
     * })
     */
    private $idemp;

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
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


}

