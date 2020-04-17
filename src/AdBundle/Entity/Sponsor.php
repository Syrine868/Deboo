<?php


namespace AdBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AdBundle\Entity\Ad;

/**
 * Sponsor
 *
 * @ORM\Table(name="Sponsor")
 * @ORM\Entity
 */
class Sponsor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @ORM\OneToMany(targetEntity="Ad")
     */
    private $Name;

    /**
     * @ORM\Column(type="string")
     *@Assert\Email(message="the email '{{value}} is not valid")
     */
    private $Email;
    /**
     * @ORM\Column(type="string",length=8)
     *
     * @Assert\Regex(
     *     pattern= "/^[0-9]+$/i")
     */

    private $phone;
    /**
     * @var DateTime
     *@ORM\Column(name="creationdate", type="date",unique=true)
     */
    private $creationdate;
    /**
     * @ORM\Column(type="string", length=255)
     */

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $local;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @param DateTime $creationdate
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;
    }

    /**
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local)
    {
        $this->local = $local;
    }

    public function __toString()
    {
        return $this->Name;
    }




}