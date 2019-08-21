<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_icone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Distillerie", mappedBy="region", orphanRemoval=true)
     */
    private $distilleries;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desc1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desc2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desc3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desc4;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageRegion", mappedBy="region", orphanRemoval=true)
     */
    private $imagesRegion;

    public function __construct()
    {
        $this->distilleries = new ArrayCollection();
        $this->imagesRegion = new ArrayCollection();
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

    public function __toString()
    {
        return $this->nom;
    }

    public function getUrlIcone(): ?string
    {
        return $this->url_icone;
    }

    public function setUrlIcone(string $url_icone): self
    {
        $this->url_icone = $url_icone;

        return $this;
    }

    /**
     * @return Collection|Distillerie[]
     */
    public function getDistilleries(): Collection
    {
        return $this->distilleries;
    }

    public function addDistillery(Distillerie $distillery): self
    {
        if (!$this->distilleries->contains($distillery)) {
            $this->distilleries[] = $distillery;
            $distillery->setRegion($this);
        }

        return $this;
    }

    public function removeDistillery(Distillerie $distillery): self
    {
        if ($this->distilleries->contains($distillery)) {
            $this->distilleries->removeElement($distillery);
            // set the owning side to null (unless already changed)
            if ($distillery->getRegion() === $this) {
                $distillery->setRegion(null);
            }
        }

        return $this;
    }

    public function getDesc1(): ?string
    {
        return $this->desc1;
    }

    public function setDesc1(?string $desc1): self
    {
        $this->desc1 = $desc1;

        return $this;
    }

    public function getDesc2(): ?string
    {
        return $this->desc2;
    }

    public function setDesc2(?string $desc2): self
    {
        $this->desc2 = $desc2;

        return $this;
    }

    public function getDesc3(): ?string
    {
        return $this->desc3;
    }

    public function setDesc3(?string $desc3): self
    {
        $this->desc3 = $desc3;

        return $this;
    }

    public function getDesc4(): ?string
    {
        return $this->desc4;
    }

    public function setDesc4(?string $desc4): self
    {
        $this->desc4 = $desc4;

        return $this;
    }

    /**
     * @return Collection|ImageRegion[]
     */
    public function getImagesRegion(): Collection
    {
        return $this->imagesRegion;
    }

    public function addImagesRegion(ImageRegion $imagesRegion): self
    {
        if (!$this->imagesRegion->contains($imagesRegion)) {
            $this->imagesRegion[] = $imagesRegion;
            $imagesRegion->setRegion($this);
        }

        return $this;
    }

    public function removeImagesRegion(ImageRegion $imagesRegion): self
    {
        if ($this->imagesRegion->contains($imagesRegion)) {
            $this->imagesRegion->removeElement($imagesRegion);
            // set the owning side to null (unless already changed)
            if ($imagesRegion->getRegion() === $this) {
                $imagesRegion->setRegion(null);
            }
        }

        return $this;
    }
}
