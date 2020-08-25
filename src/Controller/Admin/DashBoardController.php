<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use App\Repository\MponinaRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class DashBoardController.
 */
class DashBoardController extends AbstractBaseController
{
    /** @var UserRepository */
    private $userRepository;

    /** @var MponinaRepository */
    private $mponinaRepository;

    /**
     * DashBoardController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param UserRepository               $userRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, UserRepository $userRepository, MponinaRepository $mponinaRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->userRepository = $userRepository;
        $this->mponinaRepository = $mponinaRepository;
    }

    /**
     * @Route("/dashboard",name="dashboard_home", methods={"GET"})
     *
     * @return Response
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function dashboardHome()
    {
        $fokontany = $this->getUser()->getFokontany();
        $mponina = $this->mponinaRepository->countMponinaByFokontany($fokontany);
        $mpiasa = $this->userRepository->getTotalEmployee($fokontany);

        return $this->render(
            'admin/dashboard/_dashboard_home.html.twig',
            [
                'mponina' => $mponina,
                'employes' => $mpiasa,
            ]
        );
    }
}
