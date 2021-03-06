<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionStep
 *
 * @ORM\Table(name="orchard_inscriptionstep")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\InscriptionStepRepository")
 */
class OrchardInscriptionStep
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="step", type="integer", nullable=true)
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * Many orchardInscriptionSteps have One Orchard.
     * @ORM\ManyToOne(targetEntity="Orchard", inversedBy="orchardInscriptionStep")
     * @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     */
    private $orchard;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set step
     *
     * @param integer $step
     *
     * @return InscriptionStep
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return InscriptionStep
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     *
     * @return OrchardInscriptionStep
     */
    public function setOrchard(\OrchardBundle\Entity\Orchard $orchard = null)
    {
        $this->orchard = $orchard;

        return $this;
    }

    /**
     * Get orchard
     *
     * @return \OrchardBundle\Entity\Orchard
     */
    public function getOrchard()
    {
        return $this->orchard;
    }
}
