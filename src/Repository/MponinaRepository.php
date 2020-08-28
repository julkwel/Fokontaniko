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
     * @param string|null    $needle
     *
     * @return Query
     */
    public function findByFokontany(?Fokontany $fokontany, ?string $needle = '')
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.deletedAt IS NULL AND (m.firstName LIKE :needle OR m.lastName LIKE :needle)')
            ->andWhere('m.fokontany = :fokontany')
            ->andWhere('m.isAlive = :isAlive')
            ->setParameter('fokontany', $fokontany)
            ->setParameter('isAlive', true)
            ->setParameter('needle', '%'.$needle.'%')
            ->addOrderBy('m.updatedAt', 'DESC');

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
            ->andWhere('m.isAlive = :isAlive')
            ->andWhere('m.fokontany = :fokontany')
            ->setParameter('fokontany', $fokontany)
            ->setParameter('isAlive', true)
            ->getQuery()->getSingleScalarResult();

    }

    /**
     * @param Fokontany|null $fokontany
     * @param string|null    $needle
     *
     * @return array
     */
    public function findParent(?Fokontany $fokontany, ?string $needle = '')
    {
        $pattern = '%'.$needle.'%';
        $result = $this->createQueryBuilder('m')
            ->where('m.deletedAt IS NULL AND m.firstName LIKE :firstname OR m.lastName LIKE :lastName')
            ->andWhere('m.fokontany = :fokontany')
            ->andWhere('m.isAlive = :isAlive')
            ->setParameter('fokontany', $fokontany)
            ->setParameter('firstname', $pattern)
            ->setParameter('lastName', $pattern)
            ->setParameter('isAlive', true)
            ->getQuery()->execute();

        $list = [];
        /** @var Mponina $value */
        foreach ($result as $value) {
            $list[] = ['id' => $value->getFullName(), 'text' => $value->getFullName()];
        }

        return array_unique($list, SORT_REGULAR);
    }

    /**
     * @param Fokontany|null $fokontany
     * @param int|null       $genres
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMponinaByGenre(?Fokontany $fokontany, ?int $genres)
    {
        $qb = $this->createQueryBuilder('m');

        return $qb->select('COUNT(m.id)')
            ->where('m.deletedAt IS NULL')
            ->andWhere('m.isAlive = :alive')
            ->andWhere('m.fokontany = :fokontany')
            ->andWhere('m.genres = :genre')
            ->setParameters([
                'alive' => true,
                'fokontany' => $fokontany,
                'genre' => $genres,
            ])
            ->getQuery()->getSingleScalarResult();
    }
}
