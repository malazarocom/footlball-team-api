<?php

namespace App\Repository;

use App\Entity\Club;
use App\Entity\PlayerContracts;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PlayerContracts>
 *
 * @method PlayerContracts|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerContracts|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerContracts[]    findAll()
 * @method PlayerContracts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerContractsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerContracts::class);
    }

    public function add(PlayerContracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlayerContracts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countByPlayerSalaries(Club $club)
    {
        return $this->createQueryBuilder('pc')
            ->andWhere('pc.club = :club')
            ->andWhere('pc.currentInForce = :currentInForce')
            ->setParameter('club', $club)
            ->setParameter('currentInForce', true)
            ->select('SUM(pc.amount) as sum')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
