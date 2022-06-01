<?php

namespace App\DataFixtures;

use App\Entity\PlayerFactory;
use App\Entity\ClubFactory;
use App\Entity\PlayerContractFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $club) {
            list($name, $slug, $budget, $players) = $club;
            $newClub = ClubFactory::create($name, $slug, $budget);

            if (empty($players)) {
                $manager->persist($newClub);
                $manager->flush();
                continue;
            }

            foreach ($players as $player) {
                list($dorsal, $name, $position, $marketValue) = $player;
                $newPlayer = PlayerFactory::create($name, null, $dorsal, $position, $marketValue);
                $newClub->addPlayer($newPlayer);
                $playerContract = PlayerContractFactory::create($newPlayer, $newClub, $marketValue, true);
                $newPlayer->addPlayerContract($playerContract);
            }

            $manager->persist($newClub);
        }

        $manager->flush();
    }

    private function getData(): mixed
    {

        return [
            ['Deportivo Alavés SAD', 'alaves', 500, []],
            ['Athletic Club', 'athletic', 600, [
                [1, 'Unai Simón', 'Portero', 6],
                [2, 'Álex Petxa', 'Lateral derecho', 4],
                [4, 'Iñigo Martinez', 'Defensa central', 8],
                [5, 'Yeray Álvarex', 'Defensa central', 4],
                [6, 'Mikel Vesga', 'Pivote', 4],
                [7, 'Álex Berenguer', 'Extremo derecho', 4],
                [9, 'Iñaki Williams', 'Delantero centro', 4],
                [10, 'Iker Muniain', 'Extremo izquierdo', 7],
                [14, 'Dani García', 'Mediocentro', 4],
                [17, 'Yuri Berchiche', 'Lateral izquierdo', 4],
                [24, 'Mikel Balenziaga', 'Lateral izquierdo', 4],
                [22, 'Raúl García', 'Delantero centro', 4],
                [30, 'Nico Williams', 'Extremo derecho', 4],
                [19, 'Oier Zarraga', 'Mediocentro', 4],
            ]],
            ['Club Atlético de Madrid SAD', 'atletico', 500, []],
            ['FC Barcelona', 'barsa', 600, []],
            ['Real Betis', 'betis', 500, []],
            ['Cádiz Club de Fútbol SAD', 'cadiz', 500, []],
            ['Real Club Celta de Vigo SAD', 'celta', 500, []],
            ['Elche Club de Fútbol SAD', 'elche', 500, []],
            ['Reial Club Deportiu Espanyol de Barcelona SAD', 'espanyol', 500, []],
            ['Getafe Club de Fútbol SAD', 'getafe', 500, []],
            ['Granada Club de Fútbol SAD', 'granada', 500, []],
            ['Levante Unión Deportiva SAD', 'levante', 500, []],
            ['Real Club Deportivo Mallorca SAD', 'real_mallorca', 500, []],
            ['Club Atlético Osasuna', 'Osasuna', 500, []],
            ['Rayo Vallecano de Madrid SAD', 'rayo_vallecano', 500, []],
            ['Real Madrid Club de Fútbol', 'real_madrid', 500, []],
            ['Real Sociedad de Fútbol SAD', 'real_sociedad', 500, []],
            ['Sevilla Fútbol Club SAD', 'sevilla', 500, []],
            ['Valencia Club de Fútbol SAD', 'valencia', 500, []],
            ['Villarreal Club de Fútbol SAD', 'villarreal', 500, []],
        ];
    }
}
