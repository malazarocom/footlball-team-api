<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\Trainer;

class TrainerFactory
{
    public static function create(string $name, ?Club $club, float $marketValue): Trainer
    {
        $trainer = new Trainer();
        $trainer->setClub($club);
        $trainer->setName($name);
        $trainer->setMarketValue($marketValue);

        return $trainer;
    }
}
