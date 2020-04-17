<?php

namespace EquipementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity
 */
class Employee
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEmp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idemp;

    /**
     * @var string
     *
     * @ORM\Column(name="lastNameEmp", type="string", length=20, nullable=false)
     */
    protected $lastnameemp;

    /**
     * @var string
     *
     * @ORM\Column(name="firstNameEmp", type="string", length=20, nullable=false)
     */
    private $firstnameemp;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", nullable=false)
     */
    private $phone;

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="float", precision=10, scale=0, nullable=false)
     */
    private $salary;

    /**
     * @var string
     *
     * @ORM\Column(name="emailAddress", type="string", length=255, nullable=false)
     */
    private $emailaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=30, nullable=false)
     */
    private $fonction;

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getEmailaddress()
    {
        return $this->emailaddress;
    }

    /**
     * @return string
     */
    public function getFirstnameemp()
    {
        return $this->firstnameemp;
    }

    /**
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @return string
     */
    public function getLastnameemp()
    {
        return $this->lastnameemp;
    }

    /**
     * @return int
     */
    public function getIdemp()
    {
        return $this->idemp;
    }

    /**
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="nbAbs", type="integer", nullable=false)
     */
    private $nbabs;


    /**
     * @param string $emailaddress
     */
    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;
    }

    /**
     * @param string $firstnameemp
     */
    public function setFirstnameemp($firstnameemp)
    {
        $this->firstnameemp = $firstnameemp;
    }

    /**
     * @param string $fonction
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
    }

    /**
     * @param int $idemp
     */
    public function setIdemp($idemp)
    {
        $this->idemp = $idemp;
    }

    /**
     * @param string $lastnameemp
     */
    public function setLastnameemp($lastnameemp)
    {
        $this->lastnameemp = $lastnameemp;
    }

    /**
     * @param float $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
    public function __toString() {
        return "some string representation of your object";
    }

    /**
     * @return int
     */
    public function getNbabs()
    {
        return $this->nbabs;
    }

    /**
     * @param int $nbabs
     * @return \EmployeBundle\Entity\Employee
     */
    public function setNbabs(int $nbabs)
    {
        $this->nbabs = $nbabs;
        return $this;
    }
}

