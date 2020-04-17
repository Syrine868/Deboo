<?php

namespace MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment
{
    /**
     * @var string
     *
     * @ORM\Column(name="equipmentName", type="string", length=255, nullable=false)
     */
    private $equipmentname;

    /**
     * @var string
     *
     * @ORM\Column(name="rawMaterial", type="string", length=255, nullable=false)
     */
    private $rawmaterial;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipment;


}

