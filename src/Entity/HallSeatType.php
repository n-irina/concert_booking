<?php

namespace App\Entity;

use App\Repository\HallSeatTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallSeatTypeRepository::class)]
class HallSeatType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\ManyToOne(inversedBy: 'hallSeatTypes')]
    private ?hall $hall = null;

    #[ORM\ManyToOne(inversedBy: 'hallSeatTypes')]
    private ?seatType $seat_type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getHall(): ?hall
    {
        return $this->hall;
    }

    public function setHall(?hall $hall): static
    {
        $this->hall = $hall;

        return $this;
    }

    public function getSeatType(): ?seatType
    {
        return $this->seat_type;
    }

    public function setSeatType(?seatType $seat_type): static
    {
        $this->seat_type = $seat_type;

        return $this;
    }
}
