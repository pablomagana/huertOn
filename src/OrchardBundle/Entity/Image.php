<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="src", type="text", nullable=true)
     */
    private $src;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Many Images have One Orchard.
     * @ORM\ManyToOne(targetEntity="Orchard", inversedBy="images")
     * @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     */
    private $orchard;

    /**
     * Many Images have One Event.
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event", inversedBy="images")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set src
     *
     * @param string $src
     *
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     *
     * @return Image
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

    /**
     * Set event
     *
     * @param \EventBundle\Entity\Event $event
     *
     * @return Image
     */
    public function setEvent(\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \EventBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
