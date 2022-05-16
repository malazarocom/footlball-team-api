<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get'],
    shortName: "persona"
)]
class Persona
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $nombre = '';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $fechaNacimiento = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }
}
