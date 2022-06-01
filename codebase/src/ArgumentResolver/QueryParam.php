<?php

namespace App\ArgumentResolver;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class QueryParam
{
    public function __construct(
        private ?string $name = null,
        private bool $required = false
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): QueryParam
    {
        $this->name = $name;
        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): QueryParam
    {
        $this->required = $required;
        return $this;
    }

    public function __toString(): string
    {
        return "QueryParam[name='" . $this->getName() . "', required='" . $this->isRequired() . "']";
    }
}
