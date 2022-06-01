<?php

namespace App\Entity;

use App\Entity\Club;
use App\Entity\Trainer;
use App\Entity\TrainerContracts;

class TrainerContractFactory
{
    public static function create(
        ?Trainer $trainer,
        ?Club $club,
        float $amount,
        bool $currentInForce = true
    ): TrainerContracts {
        $trainerContract = new TrainerContracts();
        $trainerContract->setTrainer($trainer);
        $trainerContract->setClub($club);
        $trainerContract->setAmount($amount);
        $trainerContract->setCurrentInForce($currentInForce);

        return $trainerContract;
    }
}
