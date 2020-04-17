<?php

namespace EquipementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idequipment;

    /**
     * @var string
     * @Assert\NotBlank
     *@Assert\Length(min=3)
     * message="nom non valide"
     * @ORM\Column(name="equipmentName", type="string", length=255, nullable=false)
     */
    protected $equipmentname;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * message="matiéres premiéres non valide"
     * @ORM\Column(name="rawMaterial", type="string", length=255, nullable=false)
     */
    private $rawmaterial;

    /**
     * @return string
     */
    public function getEquipmentname()
    {
        return $this->equipmentname;
    }

    /**
     * @return string
     */
    public function getRawmaterial()
    {
        return $this->rawmaterial;
    }

    /**
     * @return int
     */
    public function getIdequipment()
    {
        return $this->idequipment;
    }

    /**
     * @param string $equipmentname
     */
    public function setEquipmentname($equipmentname)
    {
        $this->equipmentname = $equipmentname;
    }

    /**
     * @param int $idequipment
     */
    public function setIdequipment($idequipment)
    {
        $this->idequipment = $idequipment;
    }

    /**
     * @param string $rawmaterial
     */
    public function setRawmaterial($rawmaterial)
    {
        $this->rawmaterial = $rawmaterial;
    }
    public function __toString() {
        return "some string representation of your object";
    }

}

