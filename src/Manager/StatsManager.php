<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Manager;

use App\Constant\GlobalConstant;
use App\Entity\Fokontany;
use App\Entity\Mponina;
use App\Repository\MponinaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class StatsManager.
 */
class StatsManager extends AbstractManager
{
    private $mponinaRepository;

    /**
     * StatsManager constructor.
     *
     * @param UserPasswordEncoderInterface $passEncoder
     * @param EntityManagerInterface       $entityManager
     * @param MponinaRepository            $mponinaRepository
     */
    public function __construct(UserPasswordEncoderInterface $passEncoder, EntityManagerInterface $entityManager, MponinaRepository $mponinaRepository)
    {
        parent::__construct($passEncoder, $entityManager);
        $this->mponinaRepository = $mponinaRepository;
    }

    /**
     * @param Fokontany $fokontany
     *
     * @return array
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function genreManager(Fokontany $fokontany)
    {
        $men = $this->mponinaRepository->getMponinaByGenre($fokontany, array_flip(GlobalConstant::GENRE)['Lahy']);
        $women = $this->mponinaRepository->getMponinaByGenre($fokontany, array_flip(GlobalConstant::GENRE)['Vavy']);

        return ['men' => $men, 'women' => $women];
    }
}
