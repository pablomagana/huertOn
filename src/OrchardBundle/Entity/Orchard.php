<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orchard
 *
 * @ORM\Table(name="orchard")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\OrchardRepository")
 *
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
     * @ORM\OneToMany(targetEntity="Image", mappedBy="orchard")
     */
    private $images;

    /**
     * @var \Doctrine\Common\Collections\Collection|OrchardType[]
     *
     * @ORM\ManyToMany(targetEntity="OrchardType", inversedBy="orchards")
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
    protected $type;

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
     protected $activity;


     /**
      * @var \Doctrine\Common\Collections\Collection|OrchardParticipate[]
      *
      * @ORM\ManyToMany(targetEntity="OrchardParticipate", inversedBy="orchards")
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
     protected $participate;

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
     protected $service;

     /**
      * Get service
      *
      * @return OrchardService
      */
     public function getService()
     {
       return $this->service;
     }

     /**
      * @param OrchardService $service
      */
     public function addOrchardService(OrchardService $service)
     {
         if ($this->service->contains($service)) {
             return;
         }

         $this->service->add($service);
         $service->addOrchard($this);
     }

     /**
      * @param OrchardService $service
      */
     public function removeOrchardService(OrchardService $service)
     {
         if (!$this->service->contains($service)) {
             return;
         }

         $this->service->removeElement($service);
         $service->removeOrchardService($this);
     }


     /**
      * Get participate
      *
      * @return OrchardParticipate
      */
     public function getParticipate()
     {
       return $this->participate;
     }

     /**
      * @param OrchardParticipate $participate
      */
     public function addOrchardParticipate(OrchardParticipate $participate)
     {
         if ($this->participate->contains($participate)) {
             return;
         }

         $this->participate->add($participate);
         $participate->addOrchard($this);
     }

     /**
      * @param OrchardParticipate $participate
      */
     public function removeOrchardParticipate(OrchardParticipate $participate)
     {
         if (!$this->participate->contains($participate)) {
             return;
         }

         $this->participate->removeElement($participate);
         $participate->removeOrchardParticipate($this);
     }



     /**
      * Get activity
      *
      * @return OrchardActivity
      */
     public function getActivity()
     {
       return $this->activity;
     }

     /**
      * @param OrchardActivity $activity
      */
     public function addOrchardActivity(OrchardActivity $activity)
     {
         if ($this->activity->contains($activity)) {
             return;
         }

         $this->activity->add($activity);
         $activity->addOrchard($this);
     }

     /**
      * @param OrchardActivity $activity
      */
     public function removeOrchardActivity(OrchardActivity $activity)
     {
         if (!$this->activity->contains($activity)) {
             return;
         }

         $this->activity->removeElement($activity);
         $activity->removeOrchardActivity($this);
     }










    /**
     * Get type
     *
     * @return OrchardType
     */
    public function getType()
    {
      return $this->type;
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

    // /**
    //  * Get the formatted address to display
    //  *
    //  * @param $separator: the separator between fields (default: ', ')
    //  * @return String
    //  * @VirtualProperty
    //  */
    // public function getAddress($separator = ', '){
    //     if($this->getNumber() != null && $this->getStreet() != null && $this->getTown() != null && $this->getZipCode()){
    //         return ucfirst(($this->getNumber()).$separator.($this->getStreet()).$separator.($this->getTown()).$separator.($this->getZipCode()));
    //     }
    //     else{
    //         return $this->getStreet();
    //     }
    // }

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
      $this->type= new ArrayCollection();
      $this->images = new ArrayCollection();
      $this->activity = new ArrayCollection();
      $this->participate = new ArrayCollection();
      $this->service = new ArrayCollection();
      $this->inscriptionStep = new ArrayCollection();

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
     * @param OrchardType $type
     */
    public function addOrchardType(OrchardType $type)
    {
        if ($this->type->contains($type)) {
            return;
        }

        $this->type->add($type);
        $type->addOrchard($this);
    }

    /**
     * @param OrchardType $type
     */
    public function removeOrchardType(OrchardType $type)
    {
        if (!$this->type->contains($type)) {
            return;
        }

        $this->type->removeElement($type);
        $type->removeOrchardType($this);
    }


    /**
     * Set projectStart
     *
     * @param text $projectStart
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
     * @return text
     */
    public function getProjectStart()
    {
        return $this->projectStart;
    }


    /**
     * Set governanceModel
     *
     * @param text $governanceModel
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
     * @return text
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
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add type
     *
     * @param \OrchardBundle\Entity\OrchardType $type
     *
     * @return Orchard
     */
    public function addType(\OrchardBundle\Entity\OrchardType $type)
    {
        $this->type[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \OrchardBundle\Entity\OrchardType $type
     */
    public function removeType(\OrchardBundle\Entity\OrchardType $type)
    {
        $this->type->removeElement($type);
    }

    /**
     * Add activity
     *
     * @param \OrchardBundle\Entity\OrchardActivity $activity
     *
     * @return Orchard
     */
    public function addActivity(\OrchardBundle\Entity\OrchardActivity $activity)
    {
        $this->activity[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \OrchardBundle\Entity\OrchardActivity $activity
     */
    public function removeActivity(\OrchardBundle\Entity\OrchardActivity $activity)
    {
        $this->activity->removeElement($activity);
    }

    /**
     * Add participate
     *
     * @param \OrchardBundle\Entity\OrchardParticipate $participate
     *
     * @return Orchard
     */
    public function addParticipate(\OrchardBundle\Entity\OrchardParticipate $participate)
    {
        $this->participate[] = $participate;

        return $this;
    }

    /**
     * Remove participate
     *
     * @param \OrchardBundle\Entity\OrchardParticipate $participate
     */
    public function removeParticipate(\OrchardBundle\Entity\OrchardParticipate $participate)
    {
        $this->participate->removeElement($participate);
    }

    /**
     * Add service
     *
     * @param \OrchardBundle\Entity\OrchardService $service
     *
     * @return Orchard
     */
    public function addService(\OrchardBundle\Entity\OrchardService $service)
    {
        $this->service[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \OrchardBundle\Entity\OrchardService $service
     */
    public function removeService(\OrchardBundle\Entity\OrchardService $service)
    {
        $this->service->removeElement($service);
    }
}
