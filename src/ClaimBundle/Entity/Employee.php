<?php

namespace ClaimBundle\Entity;

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
    private $lastnameemp;

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
    public function getIdemp()
    {
        return $this->idemp;
    }

    /**
     * @param int $idemp
     */
    public function setIdemp($idemp)
    {
        $this->idemp = $idemp;
    }

    /**
     * @return string
     */
    public function getLastnameemp()
    {
        return $this->lastnameemp;
    }

    /**
     * @param string $lastnameemp
     */
    public function setLastnameemp($lastnameemp)
    {
        $this->lastnameemp = $lastnameemp;
    }

    /**
     * @return string
     */
    public function getFirstnameemp()
    {
        return $this->firstnameemp;
    }

    /**
     * @param string $firstnameemp
     */
    public function setFirstnameemp($firstnameemp)
    {
        $this->firstnameemp = $firstnameemp;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

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
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return string
     */
    public function getEmailaddress()
    {
        return $this->emailaddress;
    }

    /**
     * @param string $emailaddress
     */
    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;
    }

    /**
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param string $fonction
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
    }

    /**
     * @return string
     */
    public function __toString(){
        return (string) $this->idemp;
    }

}

