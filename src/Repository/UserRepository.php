<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return Query
     */
    public function findPublic()
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles','%ROLE_USER%')
        ;

        return $qb->getQuery();
    }
}
