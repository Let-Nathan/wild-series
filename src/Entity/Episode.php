<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

#[Assert\EnableAutoMapping]
#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Season::class, inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: false)]
    public $season;

    #[ORM\Column(type: 'string', length: 60, nullable: false)]
    public $title;

    #[ORM\Column(type: 'integer', nullable: false)]
    public $number;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    public $synopsis;

    #[ORM\Column(type: 'string', length: 2500, nullable: true)]
    public $images;

    #[ORM\OneToMany(mappedBy: 'episode', targetEntity: Comment::class)]
    private $comments;

    public function __construct()
    {
        $this->season = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function getSeason(): ArrayCollection
    {
        return $this->season;
    }

    public function setSeason($season): void
    {
        $this->season = $season;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): void
    {
        $this->images = $images;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Comment>
     */
    public function getComments(): \Doctrine\Common\Collections\Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEpisode($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEpisode() === $this) {
                $comment->setEpisode(null);
            }
        }

        return $this;
    }
}
