<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository
 */

namespace App\Repository;

use App\Entity\Responsable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Responsable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Responsable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Responsable[]    findAll()
 * @method Responsable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableRepository extends ServiceEntityRepository
{
    /**
     * ResponsableRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responsable::class);
    }
}
