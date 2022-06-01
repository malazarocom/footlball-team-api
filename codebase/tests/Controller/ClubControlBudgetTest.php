<?php

namespace App\Tests\Controller;

use App\Dto\CreatePlayerDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClubControlBudgetTest extends WebTestCase
{
    public function testWhenGettingclubPlayers(): void
    {
        $client = static::createClient();
        $url = '/api/clubs/';
        $clubSlugExpected = 'athletic';
        $client->request('GET', sprintf($url . 'by-slug/%s', $clubSlugExpected));
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        $club = json_decode($client->getResponse()->getContent(), true);
        $clubId = $club['id'];
        $clubSlug = $club['slug'];
        $clubBudget = $club['budget'];
        self::assertEquals($clubSlugExpected, $clubSlug);
        $this->assertThat($clubBudget, $this->logicalAnd($this->isType('int'), $this->greaterThan(0)));

        // Add one player out of budget
        $marketValue = 601;
        $playerData = CreatePlayerDto::of('Don Telmo Zarra Onaindia', 11, 'delantero', $marketValue);

        $client->request(
            'POST',
            $url . "{$clubId}/add-players",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($playerData, 'json')
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $response);
        $clubBudget = $response['clubBudget'];
        $this->assertLessThan(0, $clubBudget - $marketValue);
    }
}
