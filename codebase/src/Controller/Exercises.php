<?php

namespace App\Controller;

use DateTime;

class Exercises
{
    private DateTime $fromTime;
    private DateTime $toTime;

    public function __construct(DateTime $fromTime, DateTime $toTime)
    {
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
    }

    public function getExercise1(): string
    {
        $dateStr = $this->fromTime->format('d/m/Y');
        $fromFormat = $this->getFormat($this->fromTime);
        $hourFromStr =  $this->fromTime->format($fromFormat);
        $toFormat = $this->getFormat($this->toTime);
        $hourToStr = $this->toTime->format($toFormat);

        return sprintf("El próximo día %s se celebrará desde las %s a las %s horas el congreso de …", $dateStr, $hourFromStr, $hourToStr);
    }

    private function getFormat($date)
    {
        // if datetime has minutes then display hour:minutes
        if ((int)$date->format('i') != 0) {
            return 'H:i';
        }

        // if datetime has only minutes display minutes
        if ((int)$date->format('H') != 0 and (int)$date->format('i') == 0) {
            return 'H';
        }
    }
}
