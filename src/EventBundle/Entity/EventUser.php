<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventUser
 *
 * @ORM\Table(name="event_user")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventUserRepository")
 */
class EventUser
{
    /**
     * @var \Doctrine\Common\Collections\Collection|EventBundle\Entity\Event[]
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event", inversedBy="users")
     */
    private $event;

    /**
     * @var \Doctrine\Common\Collections\Collection|UserBundle\Entity\User[]
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="events")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="Amount", type="integer")
     */
    private $amount;


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
     * Set amount
     *
     * @param integer $amount
     *
     * @return EventUser
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set event
     *
     * @param \EventBundle\Entity\Event $event
     *
     * @return EventUser
     */
    public function setEvent(\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;
        $event->addUser($this);
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

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return EventUser
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $user->addEvent($this);
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
}
