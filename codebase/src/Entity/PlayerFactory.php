<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\Player;

class PlayerFactory
{
    public static function create(string $name, ?Club $club, int $dorsal, string $position, float $marketValue): Player
    {
        $player = new Player();
        $player->setClub($club);
        $player->setName($name);
        $player->setDorsal($dorsal);
        $player->setPosition($position);
        $player->setMarketValue($marketValue);

        return $player;
    }
}
