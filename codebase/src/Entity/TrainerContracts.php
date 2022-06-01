<?php

namespace App\Entity;

use App\Repository\TrainerContractsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainerContractsRepository::class)]
class TrainerContracts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Trainer::class, inversedBy: 'trainerContracts', cascade: ['persist'])]
    private $trainer;

    #[ORM\ManyToOne(targetEntity: Club::class, inversedBy: 'trainerContracts')]
    private $club;

    #[ORM\Column(type: 'float')]
    private $amount;

    #[ORM\Column(type: 'boolean')]
    private $currentInForce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainer(): ?Trainer
    {
        return $this->trainer;
    }

    public function setTrainer(?Trainer $trainer): self
    {
        $this->trainer = $trainer;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function isCurrentInForce(): ?bool
    {
        return $this->currentInForce;
    }

    public function setCurrentInForce(bool $currentInForce): self
    {
        $this->currentInForce = $currentInForce;

        return $this;
    }
}
