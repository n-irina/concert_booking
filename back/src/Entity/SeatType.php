<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SeatTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SeatTypeRepository::class)]
#[ApiResource()]
class SeatType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["session_read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["session_read"])]
    private ?string $description = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'seat_type')]
    private Collection $bookings;

    /**
     * @var Collection<int, SessionSeatType>
     */
    #[ORM\OneToMany(targetEntity: SessionSeatType::class, mappedBy: 'seat_type')]
    private Collection $sessionSeatTypes;

    /**
     * @var Collection<int, HallSeatType>
     */
    #[ORM\OneToMany(targetEntity: HallSeatType::class, mappedBy: 'seat_type')]
    private Collection $hallSeatTypes;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->sessionSeatTypes = new ArrayCollection();
        $this->hallSeatTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setSeatType($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSeatType() === $this) {
                $booking->setSeatType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SessionSeatType>
     */
    public function getSessionSeatTypes(): Collection
    {
        return $this->sessionSeatTypes;
    }

    public function addSessionSeatType(SessionSeatType $sessionSeatType): static
    {
        if (!$this->sessionSeatTypes->contains($sessionSeatType)) {
            $this->sessionSeatTypes->add($sessionSeatType);
            $sessionSeatType->setSeatType($this);
        }

        return $this;
    }

    public function removeSessionSeatType(SessionSeatType $sessionSeatType): static
    {
        if ($this->sessionSeatTypes->removeElement($sessionSeatType)) {
            // set the owning side to null (unless already changed)
            if ($sessionSeatType->getSeatType() === $this) {
                $sessionSeatType->setSeatType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HallSeatType>
     */
    public function getHallSeatTypes(): Collection
    {
        return $this->hallSeatTypes;
    }

    public function addHallSeatType(HallSeatType $hallSeatType): static
    {
        if (!$this->hallSeatTypes->contains($hallSeatType)) {
            $this->hallSeatTypes->add($hallSeatType);
            $hallSeatType->setSeatType($this);
        }

        return $this;
    }

    public function removeHallSeatType(HallSeatType $hallSeatType): static
    {
        if ($this->hallSeatTypes->removeElement($hallSeatType)) {
            // set the owning side to null (unless already changed)
            if ($hallSeatType->getSeatType() === $this) {
                $hallSeatType->setSeatType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
