<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository.
 */

namespace App\Repository;

use App\Entity\Fokontany;
use App\Entity\Mponina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mponina|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mponina|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mponina[]    findAll()
 * @method Mponina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MponinaRepository extends ServiceEntityRepository
{
    /**
     * MponinaRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mponina::class);
    }

    /**
     * @param Fokontany|null $fokontany
     *
     * @return Query
     */
    public function findByFokontany(?Fokontany $fokontany)
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.deletedAt IS NULL')
            ->andWhere('m.fokontany = :fokontany')
            ->setParameter('fokontany', $fokontany);

        return $qb->getQuery();
    }
}
