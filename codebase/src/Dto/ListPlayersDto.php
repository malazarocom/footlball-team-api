<?php

namespace App\Dto;

use App\Dto\CreateClubDto;
use App\Dto\CreatePlayerDto;
use Doctrine\Common\Collections\Collection;

class ListPlayersDto
{
    private ?array $list;
    private CreateClubDto $club;

    public static function of(Collection $players): self
    {
        $listPlayersDto = new self();

        foreach ($players as $player) {
            $playerDto = CreatePlayerDto::of(
                $player->getName(),
                $player->getDorsal(),
                $player->getPosition(),
                $player->getMarketValue()
            );

            $listPlayersDto->addPlayer($playerDto);
        }

        return $listPlayersDto;
    }

    /**
     * @return array
     */
    public function getList(): ?array
    {
        return $this->list;
    }

    public function addPlayer(CreatePlayerDto $player): self
    {
        $this->list[] = $player;

        return $this;
    }

    public function setClub(CreateClubDto $club): self
    {
        $this->club = $club;
        return $this;
    }
}
