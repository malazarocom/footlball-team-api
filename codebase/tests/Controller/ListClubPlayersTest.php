<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListClubPlayersTest extends WebTestCase
{
    public function testWhenGettingclubPlayers(): void
    {
        $client = static::createClient();

        $clubSlugExpected = 'athletic';
        $client->request('GET', sprintf('/api/clubs/by-slug/%s', $clubSlugExpected));
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        $club = json_decode($client->getResponse()->getContent(), true);
        $clubSlug = $club['slug'];
        self::assertEquals($clubSlugExpected, $clubSlug);

        // Get all Athletic club players
        $client->request('GET', sprintf('/api/clubs/%s/list-players', $clubSlug));
        self::assertResponseIsSuccessful();
        $players = json_decode($client->getResponse()->getContent(), true);
        self::assertIsArray($players);

        // Get Athletic club list paginated players contains 'lateral' keyword
        $queryParams = [
            'keyword'   => 'Lateral',
            "offset"    => 0,
            "limit"     => 2
        ];

        $client->request('GET', sprintf('/api/clubs/%s/list-players', $clubSlug), $queryParams);
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
    }
}
