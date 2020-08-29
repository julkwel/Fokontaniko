<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use App\Manager\StatsManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class StatsController.
 *
 * @Route("/admin/stats")
 */
class StatsController extends AbstractBaseController
{
    /** @var StatsManager */
    private $manager;

    /**
     * StatsController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param PaginatorInterface           $paginator
     * @param StatsManager                 $statsManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, PaginatorInterface $paginator, StatsManager $statsManager)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $paginator);
        $this->manager = $statsManager;
    }

    /**
     * @Route("/genre", name="genre_stats", options={"expose"=true})
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function getGenreStats()
    {
        $data = $this->manager->genreManager($this->getUser()->getFokontany());

        return $this->json($data);
    }
}
