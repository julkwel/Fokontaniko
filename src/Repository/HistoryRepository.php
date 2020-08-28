<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository.
 */

namespace App\Repository;

use App\Entity\Fokontany;
use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    /**
     * HistoryRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    /**
     * @param Fokontany|null $fokontany
     *
     * @return Query
     */
    public function findHistoryByFokontany(?Fokontany $fokontany)
    {
        $qb = $this->createQueryBuilder('h');
        $qb->andWhere('h.fokontany = :fokontany')
            ->setParameter('fokontany', $fokontany)
            ->orderBy('h.updatedAt', 'DESC');

        return $qb->getQuery();
    }
}
