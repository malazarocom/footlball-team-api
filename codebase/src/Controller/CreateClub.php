<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\ClubFactory;
use App\Service\ClubManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateClub extends AbstractController
{

    public function __construct(
        private ClubManager $clubManager,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: "/api/clubs", name: "create", methods: ["POST"])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('budget', $data) || !is_int($data['budget'])) {
            return $this->json(["error" => "The budget is mandatory"], Response::HTTP_BAD_REQUEST);
        }

        $data = $this->serializer->serialize($data, 'json');
        $data = $this->serializer->deserialize($data, Club::class, 'json');
        $club = ClubFactory::create($data->getName(), $data->getSlug(), $data->getBudget());
        $this->clubManager->save($club);

        return $this->json([], Response::HTTP_CREATED, ["Location" => "/api/clubs/" . $club->getId()]);
    }
}
