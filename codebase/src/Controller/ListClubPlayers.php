<?php

namespace App\Controller;

use App\Annotation\Get;
use App\Dto\ListPlayersDto;
use App\ArgumentResolver\QueryParam;
use App\Repository\PlayerRepository;
use App\Repository\Club\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListClubPlayers extends AbstractController
{

    public function __construct(
        private ClubRepository $clubRepository,
        private PlayerRepository $playerRepository
    ) {
    }

    #[Get(path: "/api/clubs/{clubSlug}/list-players", name: "listClubPlayers")]
    public function listClubPlayers(
        #[QueryParam] string $clubSlug,
        #[QueryParam] string $keyword = null,
        #[QueryParam] int $offset = 0,
        #[QueryParam] int $limit = 20
    ): Response {
        $playersDto = [];

        if (is_null($keyword)) {
            $club = $this->clubRepository->findOneBy(["slug" => $clubSlug]);
            $listPlayersDto = ListPlayersDto::of($club->getPlayers());
            return $this->json($listPlayersDto);
        }

        $players = $this->playerRepository->findByKeyword($keyword, $offset, $limit);
        $listPlayersDto = ListPlayersDto::of($players->getContent());

        return $this->json($listPlayersDto);
    }
}
