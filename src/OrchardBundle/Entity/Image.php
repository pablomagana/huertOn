<?php

namespace OrchardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageFile
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="OrchardBundle\Repository\ImageRepository")
 * @Assert\Callback(methods={"validate"})
 * @Vich\Uploadable
 */
class Image
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
     * @Vich\UploadableField(mapping="orchard_image", fileNameProperty="nameImage")
     * @Assert\File(maxSize="10M")
     */
    private $Image;

    /**
     * @var string
     *
     * @ORM\Column(name="nameImage", type="string", length=255, unique=true)
     */
    private $nameImage;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="updateAt")
     *
     * @var \DateTime
     */
    private $updateAt;

    /**
     * Many Images have One Orchard.
     * @ORM\ManyToOne(targetEntity="Orchard", inversedBy="images")
     * @ORM\JoinColumn(name="orchard_id", referencedColumnName="id")
     */
    private $orchard;

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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return ImageFile
     */
    public function setImage(File $file = null)
    {
        $this->Image = $file;

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
    public function getImage()
    {
        return $this->Image;
    }
    /**
     * Set nameImage
     *
     * @param string $nameImage
     *
     * @return ImageFile
     */
    public function setNameImage($nameImage)
    {
        $this->nameImage = $nameImage;

        return $this;
    }

    /**
     * Get nameImage
     *
     * @return string
     */
    public function getNameImage()
    {
        return $this->nameImage;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Image
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
     * @return Image
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
