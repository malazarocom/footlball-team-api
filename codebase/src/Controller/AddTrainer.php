<?php

namespace App\Controller;

use App\Entity\Trainer;
use App\Annotation\Post;
use App\Entity\TrainerFactory;
use App\Service\TrainerManager;
use App\Repository\TrainerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddTrainer extends AbstractController
{
    public function __construct(
        private readonly TrainerManager $trainerManager,
        private readonly TrainerRepository $trainerRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Post(path: "/api/trainers/add", name: "addTrainer")]
    public function addTrainer(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $isRegisteredTrainer = $this->trainerRepository->isRegisteredTrainer($data['name']);

        if ($isRegisteredTrainer) {
            return $this->json(
                ["error" => sprintf(
                    "The trainer %s with name %s already exists:",
                    $isRegisteredTrainer->getId(),
                    $isRegisteredTrainer->getName()
                )],
                Response::HTTP_BAD_REQUEST
            );
        }

        $data = $this->serializer->deserialize($request->getContent(), Trainer::class, 'json');
        $trainer = TrainerFactory::create(
            $data->getName(),
            null,
            $data->getMarketValue()
        );
        $this->trainerManager->save($trainer);

        return $this->json(
            $trainer->getId(),
            Response::HTTP_CREATED,
            ["Location" => "/api/trainers/adds"]
        );
    }
}
