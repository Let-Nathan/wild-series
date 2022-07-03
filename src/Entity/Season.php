<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Program::class, inversedBy: 'seasons')]
    #[ORM\JoinColumn(nullable: false)]
    private $program;

    #[ORM\Column(type: 'integer', nullable: false)]
    public $number;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Assert\Type(type: 'integer', message: 'Only number')]
    public $years;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    public $description;

    #[ORM\Column(type: 'string', length: 2500, nullable: true)]
    public $image;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Episode::class)]
    public $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setProgram(Program $program): void
    {
        $this->program = $program;
    }

    public function getProgram(): ?ArrayCollection
    {
       return $this->program;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getYears(): int
    {
        return $this->years;
    }

    /**
     * @TODO Check if dateTime object can do the job in param
     *
     */
    public function setYears(int $date): void
    {
        $this->years = $date;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getEpisodes(): ?Collection
    {
        return $this->episodes;
    }

    public function addEpisodes(Episode $episodes): self
    {
        if (!$this->episodes->contains($episodes)) {
            $this->episodes[] = $episodes;
            $episodes->setSeason($this);
        }

        return $this;
    }

    public function removeEpisodes(Episode $episode): self
    {
        if ($this->episodes->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }
        return $this;
    }

}
