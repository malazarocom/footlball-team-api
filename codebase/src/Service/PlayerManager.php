<?php

namespace App\Service;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;

class PlayerManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Player $player): void
    {
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }
}
