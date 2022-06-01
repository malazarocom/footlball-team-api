<?php

namespace App\Controller;

use App\Service\ClubManager;
use App\Repository\PlayerRepository;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeletePlayerClub extends AbstractController
{

    public function __construct(
        private readonly ClubManager $clubManager,
        private readonly ClubRepository $clubRepository,
        private readonly PlayerRepository $playerRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: "/api/clubs/{clubId}/delete-players/{playerId}", name: "deletePlayerClub", methods: ["DELETE"])]
    public function deletePlayerClub(int $clubId, int $playerId, Request $request): Response
    {
        $club = $this->clubRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        $player = $this->playerRepository->findOneBy(["id" => $playerId]);

        if (!$player) {
            return $this->json(["error" => "Player was not found by id:" . $playerId], 404);
        }

        $this->clubManager->removeClubPlayer($club, $player);

        return $this->json(
            $player->getId(),
            Response::HTTP_NO_CONTENT,
            ["Location" => sprintf("/api/clubs/%s/delete-players/%s", $club->getId(), $player->getId())]
        );
    }
}
