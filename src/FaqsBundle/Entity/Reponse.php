<?php

namespace FaqsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="idQuestion", columns={"idQuestion"})})
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idReponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreponse;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="repQuestion", type="string", length=255, nullable=false)
     */
    private $repquestion;

    /**
     * @var \Question
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idQuestion", referencedColumnName="idQuestion")
     * })
     */
    private $question;

    /**
     * @return int
     */
    public function getIdreponse()
    {
        return $this->idreponse;
    }

    /**
     * @param int $idreponse
     */
    public function setIdreponse($idreponse)
    {
        $this->idreponse = $idreponse;
    }

    /**
     * @return string
     */
    public function getRepquestion()
    {
        return $this->repquestion;
    }

    /**
     * @param string $repquestion
     */
    public function setRepquestion($repquestion)
    {
        $this->repquestion = $repquestion;
    }

    /**
     * @return \Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param \Question $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }
    public  function __construct()
    {
        $this->question = new ArrayCollection();

    }

}

