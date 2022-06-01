<?php

namespace App\Repository;

use App\Dto\Page;
use App\Entity\Player;
use App\Dto\CreatePlayerDto;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function add(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function isRegisteredPlayer(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findByKeyword(string $q, int $offset = 0, int $limit = 20): Page
    {
        $query = $this->createQueryBuilder("p")
            ->andWhere("p.name like :q or p.position like :q")
            ->setParameter('q', "%" . $q . "%")
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $c = count($paginator);
        $content = new ArrayCollection();

        foreach ($paginator as $player) {
            $content->add(CreatePlayerDto::of(
                $player->getName(),
                $player->getDorsal(),
                $player->getPosition(),
                $player->getMarketValue()
            ));
        }

        return Page::of($content, $c, $offset, $limit);
    }
}
