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
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @param Fokontany|null $fokontany
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countMponinaByFokontany(?Fokontany $fokontany)
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.deletedAt IS NULL')
            ->andWhere('m.fokontany = :fokontany')
            ->setParameter('fokontany', $fokontany)
            ->getQuery()->getSingleScalarResult();

    }

    /**
     * @param string|null $needle
     *
     * @return array
     */
    public function findParent(?string $needle = '')
    {
        $pattern = '%'.$needle.'%';
        $result = $this->createQueryBuilder('m')
            ->where('m.firstName LIKE :firstname OR m.lastName LIKE :lastName')
            ->setParameter('firstname', $pattern)
            ->setParameter('lastName', $pattern)
            ->getQuery()->execute();

        $list = [];
        foreach ($result as $value) {
            $list[] = ['id' => $value->getFullName(), 'text' => $value->getFullName()];
        }

        return $list;
    }
}
