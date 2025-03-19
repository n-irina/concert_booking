<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource()]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_time = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hall $hall = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'session')]
    private Collection $bookings;

    /**
     * @var Collection<int, SessionSeatType>
     */
    #[ORM\OneToMany(targetEntity: SessionSeatType::class, mappedBy: 'session')]
    private Collection $sessionSeatTypes;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->sessionSeatTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeInterface $date_time): static
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): static
    {
        $this->hall = $hall;

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
            $booking->setSession($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSession() === $this) {
                $booking->setSession(null);
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
            $sessionSeatType->setSession($this);
        }

        return $this;
    }

    public function removeSessionSeatType(SessionSeatType $sessionSeatType): static
    {
        if ($this->sessionSeatTypes->removeElement($sessionSeatType)) {
            // set the owning side to null (unless already changed)
            if ($sessionSeatType->getSession() === $this) {
                $sessionSeatType->setSession(null);
            }
        }

        return $this;
    }
}
