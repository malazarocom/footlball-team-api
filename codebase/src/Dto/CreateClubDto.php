<?php

namespace App\Dto;

class CreateClubDto
{
    private string $name;
    private string $slug;
    private float $budget;
    private int $id;

    public static function of(string $name, string $slug, float $budget): self
    {
        $dto = new self();
        $dto->setName($name)->setSlug($slug)->setBudget($budget);
        return $dto;
    }

    public function setId(mixed $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): mixed
    {
        return $this->id;
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

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getBudget(): float
    {
        return $this->budget;
    }
}
