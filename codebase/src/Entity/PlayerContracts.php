<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayerContractsRepository;

#[ORM\Entity(repositoryClass: PlayerContractsRepository::class)]
class PlayerContracts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'float')]
    private float $amount;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'playerContracts', cascade: ['persist'])]
    private Player $player;

    #[ORM\ManyToOne(targetEntity: Club::class, inversedBy: 'playerContracts')]
    private Club $club;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $currentInForce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function isCurrentInForce(): ?bool
    {
        return $this->currentInForce;
    }

    public function setCurrentInForce(?bool $currentInForce): self
    {
        $this->currentInForce = $currentInForce;

        return $this;
    }
}
