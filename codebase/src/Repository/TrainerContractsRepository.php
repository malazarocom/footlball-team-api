<?php

namespace App\Repository;

use App\Entity\Trainer;
use App\Entity\TrainerContracts;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TrainerContracts>
 *
 * @method TrainerContracts|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainerContracts|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainerContracts[]    findAll()
 * @method TrainerContracts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainerContractsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainerContracts::class);
    }

    public function add(TrainerContracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrainerContracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countByTrainersSalaries(Trainer $trainer)
    {
        return $this->createQueryBuilder('pc')
            ->andWhere('pc.club = :club')
            ->andWhere('pc.currentInForce = :currentInForce')
            ->setParameter('trainer', $trainer)
            ->setParameter('currentInForce', true)
            ->select('SUM(pc.amount) as sum')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
