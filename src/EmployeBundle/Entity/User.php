<?php


// src/EmployeBundle/Entity/User.php
namespace EmployeBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 ** @ORM\Entity
 ** @ORM\Table(name="fos_user")
 **/
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int
     */
    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->addRole('ROLE_CLIENT');
    }





}