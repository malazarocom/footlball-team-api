<?php

namespace App\Tests\Controller;

use App\Dto\CreateTrainerDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddTrainerTest extends WebTestCase
{
    public function testWhenAddingTrainer(): void
    {
        $client = static::createClient();

        // Add existing trainer  *************************************************************************
        $url = '/api/trainers/';
        $trainerData = CreateTrainerDto::of('David Vidal', 8);

        $client->request(
            'POST',
            $url . "add",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($trainerData, 'json')
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        // Add not existing trainer  *************************************************************************
        $trainerData = CreateTrainerDto::of('Marcelo Bielsa', 10);

        $client->request(
            'POST',
            $url . "add",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($trainerData, 'json')
        );
        $this->assertResponseIsSuccessful();
    }
}
