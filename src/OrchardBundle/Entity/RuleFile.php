<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 *
 * @ORM\Table(name="ruleFile")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\RuleFileRepository")
 * @Vich\Uploadable
 */
class RuleFile
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
     * @var File
     *
     * @Vich\UploadableField(mapping="orchard_file", fileNameProperty="nameFile")
     */
    private $File;

    /**
     * @var string
     *
     * @ORM\Column(name="nameFile", type="string", length=255, unique=true)
     */
    private $nameFile;


    /**
     * one rulefiles have One Orchard.
     * @ORM\OneToOne(targetEntity="Orchard", inversedBy="ruleFile")
     * @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     */
    private $orchard;



    /**
     * @var string
     *
     * @ORM\Column(name="updateAt")
     *
     * @var \DateTime
     */
    private $updateAt;


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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return RuleFile
     */
    public function setFile(File $file = null)
    {
        $this->File = $file;

        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile()
    {
        return $this->File;
    }



    /**
     * Set nameFile
     *
     * @param string $nameFile
     *
     * @return RuleFile
     */
    public function setNameFile($nameFile)
    {
        $this->nameFile = $nameFile;

        return $this;
    }

    /**
     * Get nameFile
     *
     * @return string
     */
    public function getNameFile()
    {
        return $this->nameFile;
    }

    /**
     * Set updateAt
     *
     * @param string $updateAt
     *
     * @return RuleFile
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set orchard
     *
     * @param \OrchardBundle\Entity\Orchard $orchard
     *
     * @return RuleFile
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
}
