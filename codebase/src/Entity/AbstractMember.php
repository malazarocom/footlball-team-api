<?php

namespace App\Entity;

use App\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks()]
class AbstractMember extends AbstractEntity
{
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name;

    #[ORM\Column(type: 'float')]
    private $MarketValue;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMarketValue(): ?float
    {
        return $this->MarketValue;
    }

    public function setMarketValue(float $MarketValue): self
    {
        $this->MarketValue = $MarketValue;

        return $this;
    }
}
