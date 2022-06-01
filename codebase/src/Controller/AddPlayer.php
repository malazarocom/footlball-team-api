<?php

namespace App\Controller;

use App\Entity\Player;
use App\Annotation\Post;
use App\Entity\PlayerFactory;
use App\Service\PlayerManager;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddPlayer extends AbstractController
{
    public function __construct(
        private readonly PlayerManager $playerManager,
        private readonly PlayerRepository $playerRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Post(path: "/api/players/add", name: "addPlayer")]
    public function addPlayer(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $isRegisteredPlayer = $this->playerRepository->isRegisteredPlayer($data['name']);

        if ($isRegisteredPlayer) {
            return $this->json(
                ["error" => sprintf(
                    "The player %s with name %s already exists:",
                    $isRegisteredPlayer->getId(),
                    $isRegisteredPlayer->getName()
                )],
                Response::HTTP_BAD_REQUEST
            );
        }

        $data = $this->serializer->deserialize($request->getContent(), Player::class, 'json');
        $player = PlayerFactory::create(
            $data->getName(),
            null,
            $data->getDorsal(),
            $data->getPosition(),
            $data->getMarketValue()
        );
        $this->playerManager->save($player);

        return $this->json(
            $player->getId(),
            Response::HTTP_CREATED,
            ["Location" => "/api/players/adds"]
        );
    }
}
