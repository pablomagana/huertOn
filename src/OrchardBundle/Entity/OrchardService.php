<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OrchardService
 *
 * @ORM\Table(name="orchard_service")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\OrchardServiceRepository")
 */
class OrchardService
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection|Orchard[]
     *
     * @ORM\ManyToMany(targetEntity="Orchard", mappedBy="orchardService")
     */
    private $orchards;


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
     * Set name
     *
     * @param string $name
     *
     * @return OrchardService
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Get orchards
     *
     * @return string
     */
    public function getOrchards()
    {
        return $this->orchards;
    }



    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->orchards = new ArrayCollection();
    }

    /**
     * @param Orchard $orchard
     */
    public function addOrchard(Orchard $orchard)
    {
        if ($this->orchards->contains($orchard)) {
            return;
        }

        $this->orchards->add($orchard);
        $orchard->addOrchardService($this);
    }

    /**
     * @param Orchard $orchard
     */
    public function removeOrchard(Orchard $orchard)
    {
        if (!$this->orchards->contains($orchard)) {
            return;
        }

        $this->orchards->removeElement($orchard);
        $orchard->removeOrchardService($this);
    }

}
