<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository.
 */

namespace App\Repository;

use App\Entity\Adidy;
use App\Entity\Mponina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adidy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adidy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adidy[]    findAll()
 * @method Adidy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdidyRepository extends ServiceEntityRepository
{
    /**
     * AdidyRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adidy::class);
    }

    /**
     * @param Mponina $mponina
     *
     * @return Query
     */
    public function listAdidy(Mponina $mponina)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->andWhere('a.user = :user')
            ->setParameter('user', $mponina);

        return $qb->getQuery();
    }
}
