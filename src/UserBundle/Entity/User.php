<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username", column=@ORM\Column(type="string", name="username", length=180, unique=false, nullable=false)),
 *      @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(type="string", name="username_canonical", length=180, unique=false, nullable=false))
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", nullable=true)
     */
    private $googleID;

    /**
    * @var OrchardBundle\Entity\Orchard
    *
    * un usuario a muchos huertos
    * @ORM\OneToMany(
    *     targetEntity="OrchardBundle\Entity\Orchard",
    *     mappedBy="user"
    * )
    */
    private $orchard;

    /**
     *
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\EventUser", mappedBy="event")
     */
    private $events;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return User
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set googleID
     *
     * @param string googleID
     *
     * @return User
     */
    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;

        return $this;
    }

    /**
     * Get googleID
     *
     * @return string
     */
    public function getGoogleID()
    {
        return $this->googleID;
    }

    /**
     * Add orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     *
     * @return User
     */
    public function addOrchard(\OrchardBundle\Entity\Orchard $orchard)
    {
        $this->orchard[] = $orchard;

        return $this;
    }

    /**
     * Remove orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     */
    public function removeOrchard(\OrchardBundle\Entity\Orchard $orchard)
    {
        $this->orchard->removeElement($orchard);
    }

    /**
     * Get orchard
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrchard()
    {
        return $this->orchard;
    }

    /**
     * Add event
     *
     * @param \EventBundle\Entity\EventUser $event
     *
     * @return User
     */
    public function addEvent(\EventBundle\Entity\EventUser $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \EventBundle\Entity\EventUser $event
     */
    public function removeEvent(\EventBundle\Entity\EventUser $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
