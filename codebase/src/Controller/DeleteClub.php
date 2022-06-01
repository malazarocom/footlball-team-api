<?php

namespace App\Controller;

use App\Repository\Club\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteClub extends AbstractController
{

    public function __construct(
        private readonly ClubRepository $clubRepository,
        private EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: "/api/clubs/{clubId}", name: "deleteClub", methods: ["DELETE"])]
    public function deleteClub(int $clubId, Request $request): Response
    {
        $club = $this->clubRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        $this->entityManager->remove($club);

        return $this->json([], 204, ["Location" => "/api/clubs/" . $club->getId()]);
    }
}
