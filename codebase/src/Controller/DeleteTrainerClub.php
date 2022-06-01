<?php

namespace App\Controller;

use App\Service\ClubManager;
use App\Repository\TrainerRepository;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteTrainerClub extends AbstractController
{

    public function __construct(
        private readonly ClubManager $clubManager,
        private readonly ClubRepository $clubRepository,
        private readonly TrainerRepository $trainerRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: "/api/clubs/{clubId}/delete-trainers/{trainerId}", name: "deleteTrainerClub", methods: ["DELETE"])]
    public function deleteTrainerClub(int $clubId, int $trainerId, Request $request): Response
    {
        $club = $this->clubRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        $trainer = $this->trainerRepository->findOneBy(["id" => $trainerId]);

        if (!$trainer) {
            return $this->json(["error" => "Trainer was not found by id:" . $trainerId], 404);
        }

        $this->clubManager->removeClubTrainer($club, $trainer);

        return $this->json(
            $trainer->getId(),
            Response::HTTP_NO_CONTENT,
            ["Location" => sprintf("/api/clubs/%s/delete-trainers/%s", $club->getId(), $trainer->getId())]
        );
    }
}
