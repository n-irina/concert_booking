<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Filter\ArtistEventsFilter;
use App\Filter\FutureEventsFilter;
use App\Filter\HallEventsFilter;
use App\Filter\HomeEventsFilter;
use App\Filter\PastEventsFilter;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource(
    normalizationContext: [
        "groups" => ["event_read"],
    ],
    operations:[
        new Get(),
        new GetCollection()
    ]
)]
#[ApiFilter(FutureEventsFilter::class)] // url: /api/events?future=true
#[ApiFilter(PastEventsFilter::class)] // url: /api/events?future=false
#[ApiFilter(HallEventsFilter::class)] // url: /api/events?hall=***
#[ApiFilter(ArtistEventsFilter::class)] // url: /api/events?artist=**
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["event_read", "session_read", "category_read", "hall_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["event_read", "session_read", "artist_read", "category_read", "hall_read"])]
    private ?string $name = null;

    #[ORM\Column(length: 355)]
    #[Groups(["event_read", "session_read"])]
    private ?string $description = null;

    /**
     * @var Collection<int, Artist>
     */
    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'events')]
    #[Groups(["event_read", "session_read", "hall_read"])]
    private Collection $artist;

    /**
     * @var Collection<int, Session>
     * 
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'event', cascade: ['persist', 'remove'])]
    #[Groups(["event_read"])]
    private Collection $sessions;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["event_read", "session_read", "artist_read", "category_read", "hall_read"])]
    private ?string $picture_path = null;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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
     * @return Collection<int, artist>
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(artist $artist): static
    {
        if (!$this->artist->contains($artist)) {
            $this->artist->add($artist);
        }

        return $this;
    }

    public function removeArtist(artist $artist): static
    {
        $this->artist->removeElement($artist);

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
            $session->setEvent($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getEvent() === $this) {
                $session->setEvent(null);
            }
        }

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(?string $picture_path): static
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
    
    public function getArtistsString(): string
    {
        return implode(', ', $this->artist->map(fn($a) => $a->getNickname())->toArray());
    }
}
