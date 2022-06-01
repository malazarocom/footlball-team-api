<?php

namespace App\Tests\Controller;

use App\Dto\CreateClubDto;
use App\Dto\CreatePlayerDto;
use App\Dto\CreateTrainerDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClubCrudFlowTest extends WebTestCase
{
    public function testClubCrudFlow(): void
    {
        $client = static::createClient();

        // 1. Create a new club ******************************************************************************
        $clubData = CreateClubDto::of("New Team FC", "newteam", 490.0);
        $json = $this->getContainer()->get('serializer')->serialize($clubData, 'json');
        $client->request(
            'POST',
            '/api/clubs',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );
        $this->assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $response = $client->getResponse();
        $url = $response->headers->get('Location');
        $this->assertNotNull($url);
        $this->assertStringStartsWith("/api/clubs", $url);

        // 2. Add player existing club *************************************************************************
        $playerData = CreatePlayerDto::of('Oliver Aton', 9, 'delantero', 19);

        $client->request(
            'POST',
            $url . "/add-players",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($playerData, 'json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $dataResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsInt($dataResponse['playerId']);

        // 3. Add trainer in existing club **********************************************************************
        $trainerData = CreateTrainerDto::of('David Vidal', 6);
        $client->request(
            'POST',
            $url . "/add-trainers",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($trainerData, 'json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        // 4. Update budget in existig club **********************************************************************
        $expectedBudget = 600;
        $updateClubData = CreateClubDto::of($clubData->getName(), $clubData->getSlug(), $expectedBudget);
        $client->request(
            'PUT',
            $url,
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($updateClubData, 'json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        // 4.1 verify the updated club budget. **********************************************************************
        $updatedClub = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($expectedBudget, $updatedClub['budget']);

        // 5. Add and delete one player club **********************************************************************
        $playerData = CreatePlayerDto::of('Benjamin Price', 1, 'portero', 8);
        $client->request(
            'POST',
            $url . "/add-players",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($playerData, 'json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $dataResponse = json_decode($client->getResponse()->getContent(), true);
        $client->request(
            'DELETE',
            $url . '/delete-players/' . $dataResponse['playerId'],
            [],
            [],
            ["CONTENT_TYPE" => "application/json"]
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);


        // 5.1 verify the player is deleted.
        // $client->request('GET', $url, [], [], ["CONTENT_TYPE" => "application/json"]);
        // $this->assertResponseStatusCodeSame(404);

        // 6. Add and delete one trainer club **********************************************************************
        $client->request(
            'POST',
            $url . "/add-trainers",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            $this->getContainer()->get('serializer')->serialize($trainerData, 'json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $response = json_decode($client->getResponse()->getContent(), true);
        $trainerId = $response['trainerId'];
        $client->request(
            'DELETE',
            $url . '/delete-trainers/' . $trainerId,
            [],
            [],
            ["CONTENT_TYPE" => "application/json"]
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
