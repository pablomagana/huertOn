<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              name     = "username_canonical",
 *              type     = "string",
 *              length   = 180,
 *              unique   = false
 *          )
 *      )
 * })
 *
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
    * @var OrchardBundle\Entity\Orchard
    *
    * un usuario a muchos huertos
    * @ORM\OneToMany(
    *     targetEntity="OrchardBundle\Entity\Orchard",
    *     mappedBy="user"
    * )
    */
    private $orchard;

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
}
