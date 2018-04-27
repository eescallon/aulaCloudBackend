<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $initialDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finalDate;

    /**
     * @ORM\Column(type="time")
     */
    private $initialHour;

    /**
     * @ORM\Column(type="time")
     */
    private $finalHour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $reservationDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allDay;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityAssistant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idRoom;

    public function getId()
    {
        return $this->id;
    }

    public function getInitialDate(): ?\DateTimeInterface
    {
        return $this->initialDate;
    }

    public function setInitialDate(\DateTimeInterface $initialDate): self
    {
        $this->initialDate = $initialDate;

        return $this;
    }

    public function getFinalDate(): ?\DateTimeInterface
    {
        return $this->finalDate;
    }

    public function setFinalDate(\DateTimeInterface $finalDate): self
    {
        $this->finalDate = $finalDate;

        return $this;
    }

    public function getInitialHour(): ?\DateTimeInterface
    {
        return $this->initialHour;
    }

    public function setInitialHour(\DateTimeInterface $initialHour): self
    {
        $this->initialHour = $initialHour;

        return $this;
    }

    public function getFinalHour(): ?\DateTimeInterface
    {
        return $this->finalHour;
    }

    public function setFinalHour(\DateTimeInterface $finalHour): self
    {
        $this->finalHour = $finalHour;

        return $this;
    }

    public function getReservationTime(): ?\DateTimeInterface
    {
        return $this->reservationTime;
    }

    public function setReservationTime(\DateTimeInterface $reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): self
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getQuantityAssistant(): ?int
    {
        return $this->quantityAssistant;
    }

    public function setQuantityAssistant(int $quantityAssistant): self
    {
        $this->quantityAssistant = $quantityAssistant;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdRoom(): ?Room
    {
        return $this->idRoom;
    }

    public function setIdRoom(?Room $idRoom): self
    {
        $this->idRoom = $idRoom;

        return $this;
    }
}
