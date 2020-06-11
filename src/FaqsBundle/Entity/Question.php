<?php

namespace FaqsBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;


/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="MyBundle\Repository\UserRepository")

 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idQuestion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idquestion;

    /**
     * @var string
     *
     * @ORM\Column(name="questionArea", type="string", length=255, nullable=false)
     */
    private $questionarea;

    /**
     * @return int
     */
    public function getIdquestion()
    {
        return $this->idquestion;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $headline;

    /**
     * @param int $idquestion
     */
    public function setIdquestion($idquestion)
    {
        $this->idquestion = $idquestion;
    }

    /**
     * @return string
     */
    public function getQuestionarea()
    {
        return $this->questionarea;
    }

    /**
     * @param string $questionarea
     */
    public function setQuestionarea($questionarea)
    {
        $this->questionarea = $questionarea;
    }

    public function __toString()
    {
        return "some string representation of your object";
    }


    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;


    public function __construct()
    {
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     *
     */

    /**
     * @param \User $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=false)
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param mixed $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
