<?php

namespace App\Entity;

use App\Repository\GameStatRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: GameStatRepository::class)]
#[ApiResource]
class GameStat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $hoursPlayed = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastPlayed = null;

    #[ORM\ManyToOne(inversedBy: 'gameStats')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'gameStats')]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoursPlayed(): ?int
    {
        return $this->hoursPlayed;
    }

    public function setHoursPlayed(int $hoursPlayed): static
    {
        $this->hoursPlayed = $hoursPlayed;

        return $this;
    }

    public function getLastPlayed(): ?\DateTimeImmutable
    {
        return $this->lastPlayed;
    }

    public function setLastPlayed(\DateTimeImmutable $lastPlayed): static
    {
        $this->lastPlayed = $lastPlayed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }


}
