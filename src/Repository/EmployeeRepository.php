<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Repository
 */

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Fokontany;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    /**
     * ResponsableRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param Fokontany|null $fokontany
     * @param string|null    $needle
     *
     * @return Query
     */
    public function findAllEmployee(?Fokontany $fokontany, ?string $needle = '')
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin(User::class, 'u')
            ->where('e.deletedAt IS NULL AND (u.firstName LIKE :needle OR u.lastName LIKE :needle OR u.userName LIKE :needle OR u.cin LIKE :needle)')
            ->andWhere('e.fokontany = :fokontany')
            ->andWhere('e.isAlive = :isAlive')
            ->setParameter('fokontany', $fokontany)
            ->setParameter('needle', '%'.$needle.'%')
            ->setParameter('isAlive', true);

        return $qb->getQuery();
    }
}
