<?php

namespace ClaimBundle\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="idEquipment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipment;

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


}

