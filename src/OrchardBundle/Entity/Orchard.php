<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orchard
 *
 * @ORM\Table(name="orchard")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\OrchardRepository")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Orchard
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
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true)
     *
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     *
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     *
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     *
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="geometry", type="text", nullable=true)
     *
     */
    private $geometry;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="text", nullable=true)
     *
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="text", nullable=true)
     *
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     *
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="step", type="string", nullable=true)
     *
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     *
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255, nullable=true)
     *
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     *
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     *
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     *
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     *
     */
    private $web;

    /**
     * @var \Doctrine\Common\Collections\Collection|Image[]
     * One Orchard has Many Images.
     * @ORM\OneToMany(targetEntity="Image", mappedBy="orchard", fetch="EAGER")
     */
    private $images;

    /**
     * @var \Doctrine\Common\Collections\Collection|OrchardType[]
     *
     * @ORM\ManyToMany(targetEntity="OrchardType", inversedBy="orchards", fetch="EAGER")
     * @ORM\JoinTable(
     *  name="orchard_orchardtype",
     *  joinColumns={
     *      @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="orchardtype_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $orchardType;

    /**
     * @var text
     *
     * @ORM\Column(name="projectStart", type="text", length=65535, nullable=true)
     *
     */
    private $projectStart;

    /**
     * @var text
     *
     * @ORM\Column(name="governanceModel", type="text", length=65535, nullable=true)
     *
     */
     private $governanceModel;


     /**
      * @var \Doctrine\Common\Collections\Collection|OrchardActivity[]
      *
      * @ORM\ManyToMany(targetEntity="OrchardActivity", inversedBy="orchards")
      * @ORM\JoinTable(
      *  name="orchard_orchardactivity",
      *  joinColumns={
      *      @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
      *  },
      *  inverseJoinColumns={
      *      @ORM\JoinColumn(name="orchardactivity_id", referencedColumnName="id")
      *  }
      * )
      */
     protected $orchardActivity;


     /**
      * @var \Doctrine\Common\Collections\Collection|OrchardParticipate[]
      *
      * @ORM\ManyToMany(targetEntity="OrchardParticipate", inversedBy="orchards", fetch="EAGER")
      * @ORM\JoinTable(
      *  name="orchard_orchardparticipate",
      *  joinColumns={
      *      @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
      *  },
      *  inverseJoinColumns={
      *      @ORM\JoinColumn(name="orchardparticipate_id", referencedColumnName="id")
      *  }
      * )
      */
     protected $orchardParticipate;

     /**
      * @var \Doctrine\Common\Collections\Collection|OrchardService[]
      *
      * @ORM\ManyToMany(targetEntity="OrchardService", inversedBy="orchards")
      * @ORM\JoinTable(
      *  name="orchard_orchardservice",
      *  joinColumns={
      *      @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
      *  },
      *  inverseJoinColumns={
      *      @ORM\JoinColumn(name="orchardservice_id", referencedColumnName="id")
      *  }
      * )
      */
     protected $orchardService;


     /**
      * @var UserBundle\Entity\User
      *
      * muchos huertos a un usuario.
      * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="orchard")
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      */
     protected $user;

     /**
      * @var boolean
      *
      * @ORM\Column(name="published", type="boolean")
      *
      */
      protected $published;

      /**
       * @var datetime
       *
       * @ORM\Column(name="created_at", type="datetime")
       *
       */
       protected $createdAt;

       /**
        * @var datetime
        *
        * @ORM\Column(name="updated_at", type="datetime")
        *
        */
        protected $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orchardType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orchardActivity = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orchardParticipate = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orchardService = new \Doctrine\Common\Collections\ArrayCollection();
        $this->published = false;
        $this->setCreatedAt(new \DateTime());
    }

    /**
      *
      * @ORM\PrePersist
      * @ORM\PreUpdate
      */
      public function updatedTimestamps()
      {
         $this->setUpdatedAt(new \DateTime('now'));

         if ($this->getCreatedAt() == null) {
             $this->setCreatedAt(new \DateTime('now'));
         }
      }

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
     * @return Orchard
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
     * Set number
     *
     * @param string $number
     *
     * @return Orchard
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Orchard
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Orchard
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Orchard
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set geometry
     *
     * @param string $geometry
     *
     * @return Orchard
     */
    public function setGeometry($geometry)
    {
        $this->geometry = $geometry;

        return $this;
    }

    /**
     * Get geometry
     *
     * @return string
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Orchard
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set step
     *
     * @param string $step
     *
     * @return Orchard
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return string
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Orchard
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return Orchard
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Orchard
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Orchard
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Orchard
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set web
     *
     * @param string $web
     *
     * @return Orchard
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set projectStart
     *
     * @param string $projectStart
     *
     * @return Orchard
     */
    public function setProjectStart($projectStart)
    {
        $this->projectStart = $projectStart;

        return $this;
    }

    /**
     * Get projectStart
     *
     * @return string
     */
    public function getProjectStart()
    {
        return $this->projectStart;
    }

    /**
     * Set governanceModel
     *
     * @param string $governanceModel
     *
     * @return Orchard
     */
    public function setGovernanceModel($governanceModel)
    {
        $this->governanceModel = $governanceModel;

        return $this;
    }

    /**
     * Get governanceModel
     *
     * @return string
     */
    public function getGovernanceModel()
    {
        return $this->governanceModel;
    }

    /**
     * Add image
     *
     * @param \OrchardBundle\Entity\Image $image
     *
     * @return Orchard
     */
    public function addImage(\OrchardBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \OrchardBundle\Entity\Image $image
     */
    public function removeImage(\OrchardBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Set images
     *
     * @param \Doctrine\Common\Collections\Collection $images
     *
     * @return Orchard
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add orchardType
     *
     * @param \OrchardBundle\Entity\OrchardType $orchardType
     *
     * @return Orchard
     */
    public function addOrchardType(\OrchardBundle\Entity\OrchardType $orchardType)
    {
        $this->orchardType[] = $orchardType;

        return $this;
    }

    /**
     * Remove orchardType
     *
     * @param \OrchardBundle\Entity\OrchardType $orchardType
     */
    public function removeOrchardType(\OrchardBundle\Entity\OrchardType $orchardType)
    {
        $this->orchardType->removeElement($orchardType);
    }

    /**
     * Set orchardType
     *
     * @param \Doctrine\Common\Collections\Collection $orchardType
     *
     * @return Orchard
     */
    public function setOrchardType($orchardType)
    {
        $this->orchardType = $orchardType;

        return $this;
    }

    /**
     * Get orchardType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrchardType()
    {
        return $this->orchardType;
    }

    /**
     * Add orchardActivity
     *
     * @param \OrchardBundle\Entity\OrchardActivity $orchardActivity
     *
     * @return Orchard
     */
    public function addOrchardActivity(\OrchardBundle\Entity\OrchardActivity $orchardActivity)
    {
        $this->orchardActivity[] = $orchardActivity;

        return $this;
    }

    /**
     * Remove orchardActivity
     *
     * @param \OrchardBundle\Entity\OrchardActivity $orchardActivity
     */
    public function removeOrchardActivity(\OrchardBundle\Entity\OrchardActivity $orchardActivity)
    {
        $this->orchardActivity->removeElement($orchardActivity);
    }

    /**
     * Set orchardActivity
     *
     * @param \Doctrine\Common\Collections\Collection $orchardType
     *
     * @return Orchard
     */
    public function setOrchardActivity($orchardActivity)
    {
        $this->orchardActivity = $orchardActivity;

        return $this;
    }

    /**
     * Get orchardActivity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrchardActivity()
    {
        return $this->orchardActivity;
    }

    /**
     * Add orchardParticipate
     *
     * @param \OrchardBundle\Entity\OrchardParticipate $orchardParticipate
     *
     * @return Orchard
     */
    public function addOrchardParticipate(\OrchardBundle\Entity\OrchardParticipate $orchardParticipate)
    {
        $this->orchardParticipate[] = $orchardParticipate;

        return $this;
    }

    /**
     * Remove orchardParticipate
     *
     * @param \OrchardBundle\Entity\OrchardParticipate $orchardParticipate
     */
    public function removeOrchardParticipate(\OrchardBundle\Entity\OrchardParticipate $orchardParticipate)
    {
        $this->orchardParticipate->removeElement($orchardParticipate);
    }

    /**
     * Set orchardParticipate
     *
     * @param \Doctrine\Common\Collections\Collection $orchardType
     *
     * @return Orchard
     */
    public function setOrchardParticipate($orchardParticipate)
    {
        $this->orchardParticipate = $orchardParticipate;

        return $this;
    }

    /**
     * Get orchardParticipate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrchardParticipate()
    {
        return $this->orchardParticipate;
    }

    /**
     * Add orchardService
     *
     * @param \OrchardBundle\Entity\OrchardService $orchardService
     *
     * @return Orchard
     */
    public function addOrchardService(\OrchardBundle\Entity\OrchardService $orchardService)
    {
        $this->orchardService[] = $orchardService;

        return $this;
    }

    /**
     * Remove orchardService
     *
     * @param \OrchardBundle\Entity\OrchardService $orchardService
     */
    public function removeOrchardService(\OrchardBundle\Entity\OrchardService $orchardService)
    {
        $this->orchardService->removeElement($orchardService);
    }

    /**
     * Set orchardService
     *
     * @param \Doctrine\Common\Collections\Collection $orchardService
     *
     * @return Orchard
     */
    public function setOrchardService($orchardService)
    {
        $this->orchardService = $orchardService;

        return $this;
    }

    /**
     * Get orchardService
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrchardService()
    {
        return $this->orchardService;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Orchard
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Orchard
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Orchard
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Orchard
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Orchard
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Orchard
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
