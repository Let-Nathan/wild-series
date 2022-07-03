<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\EnableAutoMapping]
#[ORM\Entity(repositoryClass: ProgramRepository::class)]
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 60, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max : 60, maxMessage: 'Max 60 charact')]
    public $title;

    #[ORM\Column(type: 'string', length: 60, nullable: false)]
    public $synopsis;

    #[ORM\Column(type: 'string', length: 2500, nullable: true)]
    public $image;

    #[ORM\Column(type: 'string', length: 60, nullable: false)]
    public $country;

    #[ORM\Column(type: 'integer', nullable: true)]
    public $years;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'programs')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'program', targetEntity: Season::class)]
    private $seasons;

    #[ORM\ManyToMany(targetEntity: Actor::class, mappedBy: 'programs')]
    private $actors;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $slug;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy : 'owners')]
    private $owner;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'watchlist')]
    #[ORM\JoinTable(name:'watchlist')]
    private $viewers;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->viewers = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    /**
     * @param mixed $synopsis
     */
    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getSeasons(): ?Collection
    {
        return $this->seasons;
    }

    /**
     * @param mixed $season
     */
    public function setSeason(Season $season): void
    {
        $this->seasons = $season;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
            $season->setProgram($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getProgram() === $this) {
                $season->setProgram(null);
            }
        }
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getYears(): int
    {
        return $this->years;
    }

    public function setYears(int $years): void
    {
        $this->years = $years;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->addProgram($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->removeElement($actor)) {
            $actor->removeProgram($this);
        }

        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;

    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getOwner(): ArrayCollection
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

}
