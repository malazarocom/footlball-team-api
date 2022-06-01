<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\AbstractMember;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
final class Player extends AbstractMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: Club::class, inversedBy: 'players')]
    private ?Club $club;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $dorsal;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $position;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: PlayerContracts::class)]
    private Collection $playerContracts;

    public function __construct()
    {
        $this->updatedTimestamps();
        $this->playerContracts = new ArrayCollection();
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
     * @return Collection<int, PlayerContracts>
     */
    public function getPlayerContracts(): Collection
    {
        return $this->playerContracts;
    }

    public function addPlayerContract(PlayerContracts $playerContract): self
    {
        if (!$this->playerContracts->contains($playerContract)) {
            $this->playerContracts[] = $playerContract;
            $playerContract->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerContract(PlayerContracts $playerContract): self
    {
        if ($this->playerContracts->removeElement($playerContract)) {
            if ($playerContract->getPlayer() === $this) {
                $playerContract->setPlayer(null);
            }
        }

        return $this;
    }

    public function getDorsal(): ?int
    {
        return $this->dorsal;
    }

    public function setDorsal(?int $dorsal): self
    {
        $this->dorsal = $dorsal;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }
}
