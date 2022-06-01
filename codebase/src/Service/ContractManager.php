<?php

namespace App\Service;

use App\Entity\PlayerContracts;
use App\Entity\TrainerContracts;
use Doctrine\ORM\EntityManagerInterface;

class ContractManager
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(
        PlayerContracts|TrainerContracts $contract,
        bool $flush = true
    ): PlayerContracts|TrainerContracts {
        $this->entityManager->persist($contract);

        if ($flush) {
            $this->entityManager->flush();
        }

        return $contract;
    }

    public function remove(PlayerContracts|TrainerContracts $contract): bool
    {
        $this->entityManager->remove($contract);
        $this->entityManager->flush();

        return true;
    }
}
