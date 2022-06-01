<?php

namespace App\Controller;

use App\Annotation\Get;
use App\Dto\CreateClubDto;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetClubBySlug extends AbstractController
{
    public function __construct(
        private ClubRepository $clubRepository
    ) {
    }

    #[Get(path: "/api/clubs/by-slug/{clubSlug}", name: "getClubbySlug")]
    public function getBySlug(string $clubSlug): Response
    {
        $club = $this->clubRepository->findOneBy(["slug" => $clubSlug]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by slug:" . $clubSlug], 404);
        }

        $clubDto = CreateClubDto::of($club->getName(), $club->getSlug(), $club->getBudget());
        $clubDto->setId($club->getId());

        return $this->json($clubDto);
    }
}
