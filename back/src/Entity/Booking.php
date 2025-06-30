<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiResource()]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["booking:read"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["booking:read"])]
    private ?\DateTimeInterface $booking_date = null;

    #[ORM\Column]
    #[Groups(["booking:read"])]
    private ?int $seat_count = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["booking:read"])]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["booking:read"])]
    private ?SeatType $seat_type = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["booking:read"])]
    private ?User $user = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
