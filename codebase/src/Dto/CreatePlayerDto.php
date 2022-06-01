<?php

namespace App\Dto;

use App\Entity\Club;
use App\Dto\CreateClubDto;

class CreatePlayerDto
{
    private string $name;
    private int $dorsal;
    private string $position;
    private float $marketValue;
    private CreateClubDto $club;

    public static function of(string $name, int $dorsal, string $position, float $marketValue): CreatePlayerDto
    {
        $dto = new CreatePlayerDto();
        $dto->setName($name)->setDorsal($dorsal)->setPosition($position)->setMarketValue($marketValue);

        return $dto;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDorsal(int $dorsal): self
    {
        $this->dorsal = $dorsal;
        return $this;
    }

    public function getDorsal(): int
    {
        return $this->dorsal;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getClub(): CreateClubDto
    {
        return $this->club;
    }

    public function setClub(CreateClubDto $club): self
    {
        $this->club = $club;
        return $this;
    }

    public function getMarketValue(): float
    {
        return $this->marketValue;
    }

    public function setMarketValue($marketValue): self
    {
        $this->marketValue = $marketValue;

        return $this;
    }
}
