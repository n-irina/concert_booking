<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionSeatTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionSeatTypeRepository::class)]
#[ApiResource()]
class SessionSeatType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $available_seats = null;

    #[ORM\ManyToOne(inversedBy: 'sessionSeatTypes')]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'sessionSeatTypes')]
    private ?SeatType $seat_type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailableSeats(): ?int
    {
        return $this->available_seats;
    }

    public function setAvailableSeats(int $available_seats): static
    {
        $this->available_seats = $available_seats;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getSeatType(): ?SeatType
    {
        return $this->seat_type;
    }

    public function setSeatType(?SeatType $seat_type): static
    {
        $this->seat_type = $seat_type;

        return $this;
    }
}
