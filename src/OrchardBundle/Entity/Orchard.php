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
}
