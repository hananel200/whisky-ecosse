<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageDistRepository")
 * @Vich\Uploadable
 */
class ImageDist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Distillerie", inversedBy="imageDists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distillerie;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $filename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="image_dist", fileNameProperty="fileName")
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"image/jpeg", "image/png"},
     *     mimeTypesMessage="Ce fichier n'est une image valide, sont accéptés JPG et PNG"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateAjout;

    public function __construct()
    {
        $this->DateAjout = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function __toString()
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDistillerie(): ?Distillerie
    {
        return $this->distillerie;
    }

    public function setDistillerie(?Distillerie $distillerie): self
    {
        $this->distillerie = $distillerie;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->DateAjout;
    }

    public function setDateAjout(\DateTimeInterface $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }


}
