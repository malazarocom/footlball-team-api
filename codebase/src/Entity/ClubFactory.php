<?php

namespace App\Entity;

use App\Entity\Club;

class ClubFactory
{

    public static function create(string $name, string $slug, float $budget): Club
    {
        $club = new Club();
        $club->setName($name);
        $club->setSlug($slug);
        $club->setBudget($budget);

        return $club;
    }
}
