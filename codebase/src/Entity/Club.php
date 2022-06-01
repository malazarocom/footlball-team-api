<?php

namespace App\Entity;

use App\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\Club\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'float')]
    private float $budget;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: Player::class, cascade: ['persist', "remove"])]
    private ?Collection $players;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: Trainer::class, cascade: ['persist', "remove"])]
    private $trainers;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: PlayerContracts::class, cascade: ['persist', "remove"])]
    private $playerContracts;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: TrainerContracts::class)]
    private $trainerContracts;


    public function __construct()
    {
        AbstractEntity::updatedTimestamps();
        $this->players = new ArrayCollection();
        $this->trainers = new ArrayCollection();
        $this->playerContracts = new ArrayCollection();
        $this->trainerContracts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): ?Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setClub($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getClub() === $this) {
                $player->setClub(null);
            }
        }

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Trainer>
     */
    public function getTrainers(): Collection
    {
        return $this->trainers;
    }

    public function addTrainer(Trainer $trainer): self
    {
        if (!$this->trainers->contains($trainer)) {
            $this->trainers[] = $trainer;
            $trainer->setClub($this);
        }

        return $this;
    }

    public function removeTrainer(Trainer $trainer): self
    {
        if ($this->trainers->removeElement($trainer)) {
            // set the owning side to null (unless already changed)
            if ($trainer->getClub() === $this) {
                $trainer->setClub(null);
            }
        }

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
            $playerContract->setClub($this);
        }

        return $this;
    }

    public function removePlayerContract(PlayerContracts $playerContract): self
    {
        if ($this->playerContracts->removeElement($playerContract)) {
            // set the owning side to null (unless already changed)
            if ($playerContract->getClub() === $this) {
                $playerContract->setClub(null);
            }
        }

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
            $trainerContract->setClub($this);
        }

        return $this;
    }

    public function removeTrainerContract(TrainerContracts $trainerContract): self
    {
        if ($this->trainerContracts->removeElement($trainerContract)) {
            // set the owning side to null (unless already changed)
            if ($trainerContract->getClub() === $this) {
                $trainerContract->setClub(null);
            }
        }

        return $this;
    }
}
