<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $developer = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    /**
     * @var Collection<int, GameStat>
     */
    #[ORM\OneToMany(targetEntity: GameStat::class, mappedBy: 'game')]
    private Collection $gameStats;

    public function __construct()
    {
        $this->gameStats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDeveloper(): ?string
    {
        return $this->developer;
    }

    public function setDeveloper(string $developer): static
    {
        $this->developer = $developer;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection<int, GameStat>
     */
    public function getGameStats(): Collection
    {
        return $this->gameStats;
    }

    public function addGameStat(GameStat $gameStat): static
    {
        if (!$this->gameStats->contains($gameStat)) {
            $this->gameStats->add($gameStat);
            $gameStat->setGame($this);
        }

        return $this;
    }

    public function removeGameStat(GameStat $gameStat): static
    {
        if ($this->gameStats->removeElement($gameStat)) {
            // set the owning side to null (unless already changed)
            if ($gameStat->getGame() === $this) {
                $gameStat->setGame(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? '';
    }


}
