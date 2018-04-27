<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SedeRepository")
 */
class Sede
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
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Area")
     */
    private $idArea;

    public function __construct()
    {
        $this->idArea = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Area[]
     */
    public function getIdArea(): Collection
    {
        return $this->idArea;
    }

    public function addIdArea(Area $idArea): self
    {
        if (!$this->idArea->contains($idArea)) {
            $this->idArea[] = $idArea;
        }

        return $this;
    }

    public function removeIdArea(Area $idArea): self
    {
        if ($this->idArea->contains($idArea)) {
            $this->idArea->removeElement($idArea);
        }

        return $this;
    }
}
