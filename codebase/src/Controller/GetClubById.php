<?php

namespace App\Controller;

use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetClubById extends AbstractController
{
    public function __construct(
        private ClubRepository $clubRepository
    ) {
    }

    #[Route(path: "/api/clubs/{clubId}", name: "byId", methods: ["GET"])]
    public function getClubById(int $clubId): Response
    {
        $club = $this->clubRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        return $this->json($club);
    }
}
