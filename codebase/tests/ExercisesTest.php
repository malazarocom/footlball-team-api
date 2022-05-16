<?php

namespace App;

use App\Controller\Exercises;
use DateTime;
use PHPUnit\Framework\TestCase;

class ExercisesTest extends TestCase
{

    public function testExercises()
    {
        $fromDateTime = new DateTime('2019-05-21 14:00');
        $toDateTime = new DateTime('2019-05-21 15:30');
        $exercise = new  Exercises($fromDateTime, $toDateTime);
        $actual = $exercise->getExercise1();
        $expected = "El próximo día 21/05/2019 se celebrará desde las 14 a las 15:30 horas el congreso de …";
        $this->assertEquals($expected, $actual, 'Testing datetimes, first hour and second hour+minute, not equals');

        $fromDateTime = new DateTime('2019-05-21 14:30');
        $toDateTime = new DateTime('2019-05-21 15:00');
        $exercise = new  Exercises($fromDateTime, $toDateTime);
        $actual = $exercise->getExercise1();
        $expected = "El próximo día 21/05/2019 se celebrará desde las 14:30 a las 15 horas el congreso de …";
        $this->assertEquals($expected, $actual, 'Testing datetimes, first hour+minute and second hour, not equals');

        $fromDateTime = new DateTime('2019-05-21 14:30');
        $toDateTime = new DateTime('2019-05-21 15:30');
        $exercise = new  Exercises($fromDateTime, $toDateTime);
        $actual = $exercise->getExercise1();
        $expected = "El próximo día 21/05/2019 se celebrará desde las 14:30 a las 15:30 horas el congreso de …";
        $this->assertEquals($expected, $actual, 'Testing datetimes, first hour+minute and second hour+minute, not equals');

        $fromDateTime = new DateTime('2019-05-21 14:00');
        $toDateTime = new DateTime('2019-05-21 15:00');
        $exercise = new  Exercises($fromDateTime, $toDateTime);
        $actual = $exercise->getExercise1();
        $expected = "El próximo día 21/05/2019 se celebrará desde las 14 a las 15 horas el congreso de …";
        $this->assertEquals($expected, $actual, 'Testing datetimes, first hour and second hour, not equals');
    }
}
