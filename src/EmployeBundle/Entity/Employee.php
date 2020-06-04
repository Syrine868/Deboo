<?php

namespace EmployeBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     * @ORM\Column(name="lastNameEmp", type="string", length=20, nullable=false)
     */
    private $lastnameemp;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="firstNameEmp", type="string", length=20, nullable=false)
     */
    private $firstnameemp;

    /**
     * @var integer
     * @Assert\GreaterThan(
     *     value = 18
     * )
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var integer
     * @Assert\GreaterThanOrEqual(
     *     value = 8
     * )
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
     *@Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(name="emailAddress", type="string", length=255, nullable=false)
     */
    private $emailaddress;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="fonction", type="string", length=30, nullable=false)
     */
    private $fonction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbAbs", type="integer", nullable=false)
     */
    private $nbabs;

    /**
     * @var string
     *
     * @ORM\Column(name="pic", type="string", length=255, nullable=true)
     */
    private $pic;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdemp()
    {
        return $this->idemp;
    }

    /**
     * @param int $idemp
     * @return Employee
     */
    public function setIdemp(int $idemp)
    {
        $this->idemp = $idemp;
        return $this;
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
     * @return Employee
     */
    public function setLastnameemp(string $lastnameemp)
    {
        $this->lastnameemp = $lastnameemp;
        return $this;
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
     * @return Employee
     */
    public function setFirstnameemp(string $firstnameemp)
    {
        $this->firstnameemp = $firstnameemp;
        return $this;
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
     * @return Employee
     */
    public function setAge(int $age): Employee
    {
        $this->age = $age;
        return $this;
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
     * @return Employee
     */
    public function setPhone(int $phone)
    {
        $this->phone = $phone;
        return $this;
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
     * @return Employee
     */
    public function setSalary(float $salary)
    {
        $this->salary = $salary;
        return $this;
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
     * @return Employee
     */
    public function setEmailaddress(string $emailaddress)
    {
        $this->emailaddress = $emailaddress;
        return $this;
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
     * @return Employee
     */
    public function setFonction(string $fonction)
    {
        $this->fonction = $fonction;
        return $this;
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
     * @return Employee
     */
    public function setNbabs(int $nbabs)
    {
        $this->nbabs = $nbabs;
        return $this;
    }

    /**
     * Get Pic
     *
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    public function setPic($pic)
    {
        $this->pic = $pic;

        return $this;
    }


}

