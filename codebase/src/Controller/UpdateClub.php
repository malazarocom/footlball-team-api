<?php

namespace App\Controller;

use App\Entity\Club;
use App\Service\ClubManager;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateClub extends AbstractController
{

    public function __construct(
        private ClubManager $clubManager,
        private ClubRepository $clubRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: "/api/clubs/{clubId}", name: "updateClub", methods: ["PUT"])]
    public function updateClub(int $clubId, Request $request): Response
    {
        $club = $this->clubRepository->find($clubId);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        $clubUpdateData = $this->serializer->deserialize($request->getContent(), Club::class, 'json');
        $club->setBudget($clubUpdateData->getBudget());

        if ($this->clubManager->checkPlayerSalaries($club)) {
            $this->clubManager->save($club);
            return $this->json($clubUpdateData, Response::HTTP_CREATED, ["Location" => "/api/clubs/" . $club->getId()]);
        }

        return $this->json(
            [
                "error" => "Club {$clubId} has to raise the budget for current player salaries.",
                'clubBudget' => $club->getBudget()
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
