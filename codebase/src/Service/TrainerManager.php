<?php

namespace App\Service;

use App\Entity\Trainer;
use Doctrine\ORM\EntityManagerInterface;

class TrainerManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Trainer $trainer): void
    {
        $this->entityManager->persist($trainer);
        $this->entityManager->flush();
    }
}
