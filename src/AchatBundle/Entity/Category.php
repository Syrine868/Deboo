<?php

namespace AchatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategory", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=20, nullable=false)
     */
    private $categoryname;

    /**
     * Category constructor.
     * @param int $idcategory
     * @param string $categoryname
     */
    public function __construct($idcategory, $categoryname)
    {
        $this->idcategory = $idcategory;
        $this->categoryname = $categoryname;
    }

    /**
     * @return int
     */
    public function getIdcategory()
    {
        return $this->idcategory;
    }

    /**
     * @param int $idcategory
     */
    public function setIdcategory($idcategory)
    {
        $this->idcategory = $idcategory;
    }

    /**
     * @return string
     */
    public function getCategoryname()
    {
        return $this->categoryname;
    }

    /**
     * @param string $categoryname
     */
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;
    }

    public function __toString()
    {
        return "";
    }


}

