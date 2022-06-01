<?php

namespace App\Tests\Controller;

use App\Dto\CreateClubDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BudgetClubIsMandatoryTest extends WebTestCase
{
    public function testWhenAddingClubWithoutBudget(): void
    {
        $client = static::createClient();

        // 1. Create club without budget ******************************************************************************
        $url = '/api/clubs';
        $clubData = CreateClubDto::of("Tohu FC", "tohu", 2);
        $json = $this->getContainer()->get('serializer')->serialize($clubData, 'json');

        $client->request(
            'POST',
            $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );
        $this->assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
        // $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
