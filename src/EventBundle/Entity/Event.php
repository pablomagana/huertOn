<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=80)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endTime", type="time")
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=3500)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="places", type="integer")
     */
    private $places;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showPlaces", type="boolean")
     *
     */
    private $showPlaces;

    /**
     * Many events have One Orchard.
     * @ORM\ManyToOne(targetEntity="OrchardBundle\Entity\Orchard", inversedBy="events", fetch="EAGER")
     * @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     */
    private $orchard;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="orchard_event", fileNameProperty="imageName")
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255, unique=true, nullable=true)
     */
    private $imageName;


    /**
     *
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\EventUser", mappedBy="user")
     */
    private $users;

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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set places
     *
     * @param integer $places
     *
     * @return Event
     */
    public function setPlaces($places)
    {
        $this->places = $places;

        return $this;
    }

    /**
     * Get places
     *
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Event
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     *
     * @return Event
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
      * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
      *
      * @return RuleFile
      */
    public function setImages(File $file = null)
    {
       $this->images = $file;
       return $this;
     }

    /**
      * @return File|null
      */
    public function getImages()
    {
       return $this->images;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Event
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set showPlaces
     *
     * @param boolean $showPlaces
     *
     * @return Event
     */
    public function setShowPlaces($showPlaces)
    {
        $this->showPlaces = $showPlaces;

        return $this;
    }

    /**
     * Get showPlaces
     *
     * @return boolean
     */
    public function getShowPlaces()
    {
        return $this->showPlaces;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Event
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Event
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Add user
     *
     * @param \EventBundle\Entity\EventUser $user
     *
     * @return Event
     */
    public function addUser(\EventBundle\Entity\EventUser $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \EventBundle\Entity\EventUser $user
     */
    public function removeUser(\EventBundle\Entity\EventUser $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
