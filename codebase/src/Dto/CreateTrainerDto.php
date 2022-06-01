<?php

namespace App\Dto;

class CreateTrainerDto
{
    private string $name;
    private float $marketValue;
    private CreateClubDto $club;

    public static function of(string $name, float $marketValue): CreateTrainerDto
    {
        $dto = new CreateTrainerDto();
        $dto->setName($name)->setMarketValue($marketValue);
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
