<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HallRepository::class)]
#[ApiResource(
    normalizationContext: [
        "groups" => ["hall_read"],
    ],
    operations:[
        new Get(),
        new GetCollection()
    ]
)]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["hall_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["event_read", "session_read", "hall_read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["session_read", "hall_read"])]
    private ?string $address = null;

    #[ORM\Column]
    #[Groups(["session_read", "hall_read"])]
    private ?int $capacity = null;

    #[ORM\Column(length: 355)]
    #[Groups(["session_read", "hall_read"])]
    private ?string $description = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'hall')]
    private Collection $sessions;

    /**
     * @var Collection<int, HallSeatType>
     */
    #[ORM\OneToMany(targetEntity: HallSeatType::class, mappedBy: 'hall')]
    private Collection $hallSeatTypes;

    #[ORM\Column(length: 255)]
    #[Groups(["hall_read", "session_read"])]
    private ?string $picture_path = null;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
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
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setHall($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getHall() === $this) {
                $session->setHall(null);
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
            $hallSeatType->setHall($this);
        }

        return $this;
    }

    public function removeHallSeatType(HallSeatType $hallSeatType): static
    {
        if ($this->hallSeatTypes->removeElement($hallSeatType)) {
            // set the owning side to null (unless already changed)
            if ($hallSeatType->getHall() === $this) {
                $hallSeatType->setHall(null);
            }
        }

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(string $picture_path): static
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
