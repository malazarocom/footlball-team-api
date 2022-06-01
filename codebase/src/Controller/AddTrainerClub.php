<?php

namespace App\Controller;

use App\Entity\Trainer;
use App\Annotation\Post;
use App\Service\ClubManager;
use App\Entity\TrainerFactory;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddTrainerClub extends AbstractController
{
    public function __construct(
        private readonly ClubManager $clubManager,
        private readonly ClubRepository $clubSearchRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Post(path: "/api/clubs/{clubId}/add-trainers", name: "addTrainers")]
    public function addTrainer(int $clubId, Request $request): Response
    {
        $club = $this->clubSearchRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found b}y id:" . $clubId], 404);
        }

        $data = $this->serializer->deserialize($request->getContent(), Trainer::class, 'json');
        $trainer = TrainerFactory::create($data->getName(), $club, $data->getMarketValue());
        $trainerContract = $this->clubManager->addClubTrainer($club, $trainer, $trainer->getMarketValue());

        if (!$trainerContract) {
            return $this->json(
                ["error" => "Club {$clubId} hasn't cash.", 'clubBudget' => $club->getBudget()],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            [
                'trainerId'     => $trainerContract->getTrainer()->getId(),
                'clubBudget'    => $trainerContract->getClub()->getBudget()
            ],
            Response::HTTP_CREATED,
            ["Location" => sprintf("/api/clubs/%s/add-trainers/%s", $club->getId(), $trainer->getId())]
        );
    }
}
