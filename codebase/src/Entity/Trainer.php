<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\AbstractMember;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrainerRepository;

#[ORM\Entity(repositoryClass: TrainerRepository::class)]
final class Trainer extends AbstractMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: Club::class, inversedBy: 'Trainers')]
    private ?Club $club;

    #[ORM\OneToMany(mappedBy: 'trainer', targetEntity: TrainerContracts::class)]
    private $trainerContracts;

    public function __construct()
    {
        $this->updatedTimestamps();
        $this->trainerContracts = new ArrayCollection();
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

    /**
     * @return Collection<int, TrainerContracts>
     */
    public function getTrainerContracts(): Collection
    {
        return $this->trainerContracts;
    }

    public function addTrainerContract(TrainerContracts $trainerContract): self
    {
        if (!$this->trainerContracts->contains($trainerContract)) {
            $this->trainerContracts[] = $trainerContract;
            $trainerContract->setTrainer($this);
        }

        return $this;
    }

    public function removeTrainerContract(TrainerContracts $trainerContract): self
    {
        if ($this->trainerContracts->removeElement($trainerContract)) {
            if ($trainerContract->getTrainer() === $this) {
                $trainerContract->setTrainer(null);
            }
        }

        return $this;
    }
}
