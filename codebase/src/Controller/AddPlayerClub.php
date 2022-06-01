<?php

namespace App\Controller;

use App\Entity\Player;
use App\Annotation\Post;
use App\Service\ClubManager;
use App\Entity\PlayerFactory;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddPlayerClub extends AbstractController
{
    public function __construct(
        private readonly ClubManager $clubManager,
        private readonly ClubRepository $clubRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Post(path: "/api/clubs/{clubId}/add-players", name: "addPlayersClub")]
    public function addPlayer(int $clubId, Request $request): Response
    {
        $club = $this->clubRepository->findOneBy(["id" => $clubId]);

        if (!$club) {
            return $this->json(["error" => "Club was not found by id:" . $clubId], 404);
        }

        $data = $this->serializer->deserialize($request->getContent(), Player::class, 'json');
        $player = PlayerFactory::create(
            $data->getName(),
            $club,
            $data->getDorsal(),
            $data->getPosition(),
            $data->getMarketValue()
        );
        $playerContract = $this->clubManager->addClubPlayer($club, $player, $data->getMarketValue());

        if (!$playerContract) {
            return $this->json(
                ["error" => "Club {$clubId} hasn't cash.", 'clubBudget' => $club->getBudget()],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            [
                'playerId'      => $playerContract->getPlayer()->getId(),
                'clubBudget'    => $playerContract->getClub()->getBudget()
            ],
            Response::HTTP_CREATED,
            ["Location" => sprintf("/api/clubs/%s/add-players/%s", $club->getId(), $player->getId())]
        );
    }
}
