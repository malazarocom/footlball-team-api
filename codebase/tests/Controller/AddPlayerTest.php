<?php

namespace App\Tests\Controller;

use App\Dto\CreatePlayerDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddPlayerTest extends WebTestCase
{
    public function testWhenAddingPlayer(): void
    {
        $client = static::createClient();

        // Add existing player  *************************************************************************
        $url = '/api/players/';
        $playerData = CreatePlayerDto::of('Oliver Aton', 9, 'delantero', 19);

        $client->request(
            'POST',
            $url . "add",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($playerData, 'json')
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        // Add not existing player  *************************************************************************
        $playerData = CreatePlayerDto::of('Philippe Calahan', 7, 'media punta', 15);

        $client->request(
            'POST',
            $url . "add",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($playerData, 'json')
        );
        $this->assertResponseIsSuccessful();
    }
}
