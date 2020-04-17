<?php
namespace AchatBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

trait HashPremium
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="premium", type="boolean")
     */
    private $premium = false;

    /**
     * @param boolean $premium
     * @return $this
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPremium()
    {
        return $this->premium;
    }
}