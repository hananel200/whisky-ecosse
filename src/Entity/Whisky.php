<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WhiskyRepository")
 */
class Whisky
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
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description3;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Distillerie", inversedBy="whiskies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distillerie;

    /**
     * @ORM\Column(type="integer")
     */
    private $ugs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WhiskyImg", mappedBy="whisky", orphanRemoval=true)
     */
    private $whiskyImgs;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $degre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;



    public function __construct()
    {
        $this->whiskyImgs = new ArrayCollection();
        $this->dateAjout = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getUgs(): ?int
    {
        return $this->ugs;
    }


    public function setUgs(int $ugs): self
    {
        $this->ugs = $ugs;

        return $this;
    }


    /**
     * @return Collection|WhiskyImg[]
     */
    public function getWhiskyImgs(): Collection
    {
        return $this->whiskyImgs;
    }

    public function addWhiskyImg(WhiskyImg $whiskyImg): self
    {
        if (!$this->whiskyImgs->contains($whiskyImg)) {
            $this->whiskyImgs[] = $whiskyImg;
            $whiskyImg->setWhisky($this);
        }

        return $this;
    }

    public function removeWhiskyImg(WhiskyImg $whiskyImg): self
    {
        if ($this->whiskyImgs->contains($whiskyImg)) {
            $this->whiskyImgs->removeElement($whiskyImg);
            // set the owning side to null (unless already changed)
            if ($whiskyImg->getWhisky() === $this) {
                $whiskyImg->setWhisky(null);
            }
        }

        return $this;
    }

    public function getDegre(): ?float
    {
        return $this->degre;
    }

    public function setDegre(?float $degre): self
    {
        $this->degre = $degre;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

}

