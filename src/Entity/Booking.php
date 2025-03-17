<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $booking_date = null;

    #[ORM\Column]
    private ?int $seat_count = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?session $session = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?seattype $seat_type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->booking_date;
    }

    public function setBookingDate(\DateTimeInterface $booking_date): static
    {
        $this->booking_date = $booking_date;

        return $this;
    }

    public function getSeatCount(): ?int
    {
        return $this->seat_count;
    }

    public function setSeatCount(int $seat_count): static
    {
        $this->seat_count = $seat_count;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSession(): ?session
    {
        return $this->session;
    }

    public function setSession(?session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getSeatType(): ?seattype
    {
        return $this->seat_type;
    }

    public function setSeatType(?seattype $seat_type): static
    {
        $this->seat_type = $seat_type;

        return $this;
    }
}
