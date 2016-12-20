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
     * @var \Doctrine\Common\Collections\Collection|UserBundle\Entity\User[]
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="orchards")
     * @ORM\JoinTable(
     *  name="orchard_users",
     *  joinColumns={
     *      @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  }
     * )
     *
     */
    protected $users;


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
     * Get users
     *
     * @return string
     */
    public function getUsers()
    {
        return $this->users;
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
      $this->users= new ArrayCollection();
      $this->type= new ArrayCollection();
    }

    /**
     * @param User $users
     */
    public function addUserGroup(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addUser($this);
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeUser($this);
    }

    /**
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Orchard
     */
    public function addUser(\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
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
        $type->addUser($this);
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


}
