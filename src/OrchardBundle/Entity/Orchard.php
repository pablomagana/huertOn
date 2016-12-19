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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     *
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     *
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     *
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255)
     *
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="geometry", type="text")
     *
     */
    private $geometry;

    /**
     * @var string
     *
     * @ORM\Column(name="step", type="string")
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
     * @ORM\Column(name="facebook", type="string", length=255)
     *
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255)
     *
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255)
     *
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     *
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     *
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255)
     *
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     *
     */
    private $type;



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

    /**
     * Get the formatted address to display
     *
     * @param $separator: the separator between fields (default: ', ')
     * @return String
     * @VirtualProperty
     */
    public function getAddress($separator = ', '){
        if($this->getNumber() != null && $this->getStreet() != null && $this->getTown() != null && $this->getZipCode()){
            return ucfirst(($this->getNumber()).$separator.($this->getStreet()).$separator.($this->getTown()).$separator.($this->getZipCode()));
        }
        else{
            return $this->getStreet();
        }
    }

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->users= new ArrayCollection();
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Orchard
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }





}
