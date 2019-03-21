<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM; 
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Logboek", mappedBy="userId")
     */
    private $logboeknaam;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logboek", mappedBy="chauffeurId")
     */
    private $chauffeurnaam;

    public function __construct()
    {
        parent::__construct();
        $this->logboeknaam = new ArrayCollection();
        $this->chauffeurnaam = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Logboek[]
     */
    public function getLogboeknaam(): Collection
    {
        return $this->logboeknaam;
    }

    public function addLogboeknaam(Logboek $logboeknaam): self
    {
        if (!$this->logboeknaam->contains($logboeknaam)) {
            $this->logboeknaam[] = $logboeknaam;
            $logboeknaam->setUserId($this);
        }

        return $this;
    }

    public function removeLogboeknaam(Logboek $logboeknaam): self
    {
        if ($this->logboeknaam->contains($logboeknaam)) {
            $this->logboeknaam->removeElement($logboeknaam);
            // set the owning side to null (unless already changed)
            if ($logboeknaam->getUserId() === $this) {
                $logboeknaam->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logboek[]
     */
    public function getChauffeurnaam(): Collection
    {
        return $this->chauffeurnaam;
    }

    public function addChauffeurnaam(Logboek $chauffeurnaam): self
    {
        if (!$this->chauffeurnaam->contains($chauffeurnaam)) {
            $this->chauffeurnaam[] = $chauffeurnaam;
            $chauffeurnaam->setChauffeurId($this);
        }

        return $this;
    }

    public function removeChauffeurnaam(Logboek $chauffeurnaam): self
    {
        if ($this->chauffeurnaam->contains($chauffeurnaam)) {
            $this->chauffeurnaam->removeElement($chauffeurnaam);
            // set the owning side to null (unless already changed)
            if ($chauffeurnaam->getChauffeurId() === $this) {
                $chauffeurnaam->setChauffeurId(null);
            }
        }

        return $this;
    }
}
