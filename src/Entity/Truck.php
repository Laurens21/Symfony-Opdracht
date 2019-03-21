<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TruckRepository")
 */
class Truck
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
    private $kenteken;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $merk;

    /**
     * @ORM\Column(type="date")
     */
    private $bouwjaar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logboek", mappedBy="truckId")
     */
    private $trucknaam;

    public function __construct()
    {
        $this->trucknaam = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKenteken(): ?string
    {
        return $this->kenteken;
    }

    public function setKenteken(string $kenteken): self
    {
        $this->kenteken = $kenteken;

        return $this;
    }

    public function getMerk(): ?string
    {
        return $this->merk;
    }

    public function setMerk(string $merk): self
    {
        $this->merk = $merk;

        return $this;
    }

    public function getBouwjaar(): ?\DateTimeInterface
    {
        return $this->bouwjaar;
    }

    public function setBouwjaar(\DateTimeInterface $bouwjaar): self
    {
        $this->bouwjaar = $bouwjaar;

        return $this;
    }

    /**
     * @return Collection|Logboek[]
     */
    public function getTrucknaam(): Collection
    {
        return $this->trucknaam;
    }

    public function addTrucknaam(Logboek $trucknaam): self
    {
        if (!$this->trucknaam->contains($trucknaam)) {
            $this->trucknaam[] = $trucknaam;
            $trucknaam->setTruckId($this);
        }

        return $this;
    }

    public function removeTrucknaam(Logboek $trucknaam): self
    {
        if ($this->trucknaam->contains($trucknaam)) {
            $this->trucknaam->removeElement($trucknaam);
            // set the owning side to null (unless already changed)
            if ($trucknaam->getTruckId() === $this) {
                $trucknaam->setTruckId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getKenteken();
    }
}
