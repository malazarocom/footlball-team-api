<?php

namespace App\Service;

use App\Entity\Club;
use App\Entity\Player;
use App\Entity\Trainer;
use App\Service\PlayerManager;
use App\Service\TrainerManager;
use App\Service\ContractManager;
use App\Entity\PlayerContractFactory;
use App\Entity\PlayerContracts;
use App\Entity\TrainerContractFactory;
use App\Entity\TrainerContracts;
use App\Repository\Club\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerContractsRepository;
use App\Repository\TrainerContractsRepository;

class ClubManager
{
    public function __construct(
        private ContractManager $contractManager,
        private ClubRepository $clubRepository,
        private EntityManagerInterface $entityManager,
        private PlayerManager $playerManager,
        private TrainerManager $trainerManager,
        private PlayerContractsRepository $playerContractsRepository,
        private TrainerContractsRepository $trainerContractsRepository
    ) {
    }

    public function save(Club $club): void
    {
        $this->entityManager->persist($club);
        $this->entityManager->flush();
    }

    public function checkPlayerSalaries(Club $club): bool
    {
        $playerSalaries = $this->playerContractsRepository->countByPlayerSalaries($club);

        if ($playerSalaries > $club->getBudget()) {
            return false;
        }

        return true;
    }

    public function remove(Club $club): void
    {
        $this->entityManager->remove($club);
        $this->entityManager->flush();
    }

    public function addClubPlayer(Club $club, Player $player, $amount): PlayerContracts|false
    {
        $contract = PlayerContractFactory::create($player, $club, $amount);
        $cash = $this->updateClubCash($club, $player);

        if ($cash) {
            $this->contractManager->save($contract);
            $club->setBudget($cash);
            $this->save($club);
            return $contract;
        }

        return false;
    }

    public function addClubTrainer(Club $club, Trainer $trainer, $amount): TrainerContracts|false
    {
        $contract = TrainerContractFactory::create($trainer, $club, $amount);
        $cash = $this->updateClubCash($club, $trainer);
        $this->contractManager->save($contract);

        if ($cash) {
            $this->contractManager->save($contract);
            $club->setBudget($cash);
            $this->save($club);
            return $contract;
        }

        return false;
    }

    public function updateClubCash(Club $club, Player|Trainer $member): false|float
    {
        $cash = $club->getBudget() - $member->getMarketValue();

        if ($cash <= 0) {
            return false;
        }

        return $cash;
    }

    public function removeClubPlayer(Club $club, Player $player): void
    {
        $contractPlayer = $this->playerContractsRepository->findOneBy([
            'club'              => $club,
            'player'            => $player,
            'currentInForce'    => true
        ]);

        if (!$contractPlayer) {
            // Contract not found
        }

        $player->setClub(null);
        $this->playerManager->save($player);
        $this->contractManager->remove($contractPlayer);
    }

    public function removeClubTrainer(Club $club, Trainer $trainer): void
    {
        $contractTrainer = $this->trainerContractsRepository->findOneBy([
            'club'              => $club,
            'trainer'           => $trainer,
            'currentInForce'    => true
        ]);

        if (!$contractTrainer) {
            // Contract not found
        }

        $trainer->setClub(null);
        $this->trainerManager->save($trainer);
        $this->contractManager->remove($contractTrainer);
    }
}
