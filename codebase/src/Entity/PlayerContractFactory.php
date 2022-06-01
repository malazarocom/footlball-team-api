<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\Player;
use App\Entity\PlayerContracts;

class PlayerContractFactory
{
    public static function create(
        ?Player $player,
        ?Club $club,
        float $amount,
        bool $currentInForce = true
    ): PlayerContracts {
        $playerContract = new PlayerContracts();
        $playerContract->setPlayer($player);
        $playerContract->setClub($club);
        $playerContract->setAmount($amount);
        $playerContract->setCurrentInForce($currentInForce);

        return $playerContract;
    }
}
