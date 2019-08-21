<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DistillerieRepository")
 */
class Distillerie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     * @Assert\LessThan(60)
     * @Assert\GreaterThan(53)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", length=255)
     * @Assert\LessThan(-1)
     * @Assert\GreaterThan(-6)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="distilleries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageDist", mappedBy="distillerie", orphanRemoval=true)
     */
    private $imageDists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Whisky", mappedBy="distillerie", orphanRemoval=true)
     */
    private $whiskies;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=100)
     */
    private $description1;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=100)
     */
    private $description2;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=100)
     */
    private $description3;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=100)
     */
    private $description4;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=100)
     */
    private $description5;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateAjout;

    public function __construct()
    {
        $this->imageDists = new ArrayCollection();
        $this->whiskies = new ArrayCollection();
        $this->DateAjout = new \DateTime();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|ImageDist[]
     */
    public function getImageDists(): Collection
    {
        return $this->imageDists;
    }

    public function addImageDist(ImageDist $imageDist): self
    {
        if (!$this->imageDists->contains($imageDist)) {
            $this->imageDists[] = $imageDist;
            $imageDist->setDistillerie($this);
        }

        return $this;
    }

    public function removeImageDist(ImageDist $imageDist): self
    {
        if ($this->imageDists->contains($imageDist)) {
            $this->imageDists->removeElement($imageDist);
            // set the owning side to null (unless already changed)
            if ($imageDist->getDistillerie() === $this) {
                $imageDist->setDistillerie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Whisky[]
     */
    public function getWhiskies(): Collection
    {
        return $this->whiskies;
    }

    public function addWhisky(Whisky $whisky): self
    {
        if (!$this->whiskies->contains($whisky)) {
            $this->whiskies[] = $whisky;
            $whisky->setDistillerie($this);
        }

        return $this;
    }


    public function removeWhisky(Whisky $whisky): self
    {
        if ($this->whiskies->contains($whisky)) {
            $this->whiskies->removeElement($whisky);
            // set the owning side to null (unless already changed)
            if ($whisky->getDistillerie() === $this) {
                $whisky->setDistillerie(null);
            }
        }

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(?string $description1): self
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): self
    {
        $this->description2 = $description2;

        return $this;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(?string $description3): self
    {
        $this->description3 = $description3;

        return $this;
    }

    public function getDescription4(): ?string
    {
        return $this->description4;
    }

    public function setDescription4(?string $description4): self
    {
        $this->description4 = $description4;

        return $this;
    }

    public function getDescription5(): ?string
    {
        return $this->description5;
    }

    public function setDescription5(?string $description5): self
    {
        $this->description5 = $description5;

        return $this;
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
