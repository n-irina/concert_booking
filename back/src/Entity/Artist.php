<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ApiResource(
    normalizationContext: [
        "groups" => ["artist_read"],
    ],
    operations:[
        new Get(),
        new GetCollection()
    ]
)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["event_read", "artist_read", 'category_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["event_read", "session_read", "artist_read", "category_read"])]
    private ?string $nickname = null;

    #[ORM\Column(length: 355)]
    #[Groups(["session_read", "artist_read"])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(["artist_read", "category_read"])]
    private ?string $image_path = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'artists')]
    #[Groups(["event_read", "session_read", "artist_read"])]
    private Collection $category;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'artist')]
    #[Groups(["artist_read", "category_read"])]
    private Collection $events;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

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

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(string $image_path): static
    {
        $this->image_path = $image_path;

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addArtist($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeArtist($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNickname();
    }

    public function getCategoriesString(): string
    {
        return implode(', ', $this->category->map(fn($c) => $c->getName())->toArray());
    }

}
