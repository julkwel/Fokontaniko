<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Employee;
use App\Manager\UserManager;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Factory\QrCodeFactoryInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController.
 *
 * @Route("/admin/user")
 */
class UserController extends AbstractBaseController
{
    /** @var UserManager */
    private $userManager;

    /** @var UserRepository */
    private $repository;

    /**
     * UserController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param UserManager                  $userManager
     * @param UserRepository               $userRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, UserManager $userManager, UserRepository $userRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->userManager = $userManager;
        $this->repository = $userRepository;
    }

    /**
     * @Route("/list", name="list_user", methods={"POST","GET"})
     *
     * @param Request        $request
     * @param UserRepository $repository
     *
     * @return Response the list of user
     */
    public function listUser(Request $request, UserRepository $repository)
    {
        $pagination = $this->paginator->paginate(
            $repository->findPublic($this->getUser()->getFokontany()),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/user/_user_list.html.twig', ['users' => $pagination]);
    }

    /**
     * @Route("/manage/{id?}", name="manage_user", methods={"POST","GET"})
     *
     * @param Request   $request
     * @param User|null $user
     *
     * @return Response
     */
    public function manageUser(Request $request, User $user = null)
    {
        $user = $user ?? new User();
        $form = $this->createForm(UserType::class, $user, ['hasUser' => $user->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userManager->handleUserBeforePersist($form, $user, $this->getUser(), true);
            if ($request->get('type')) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            if ($this->save($user)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i'.$user->getUsername().' nampidirinao!');

                return $this->redirectToRoute('dashboard_home');
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko!');

            return $this->redirectToRoute('manage_user', ['id' => $user->getId()]);
        }


        return $this->render('admin/user/_user_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/die/{id}", name="user_die", methods={"POST","GET"})
     *
     * @ParamDecryptor(params={"id"})
     *
     * @param User $user died
     *
     * @return RedirectResponse
     */
    public function onUserDie(User $user)
    {
        $user->setIsAlive(false);

        if ($this->save($user)) {
            $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovàna');

            return $this->redirectToRoute('list_user');
        }
        $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

        return $this->redirectToRoute('list_user');
    }

    /**
     * @Route("/qr-code/{id}", name="user_qr", methods={"POST","GET"})
     *
     * @param User                   $user
     * @param QrCodeFactoryInterface $qrCodeFactory
     *
     * @return Response
     */
    public function generateQr(User $user, QrCodeFactoryInterface $qrCodeFactory)
    {
        $data = $this->renderView('admin/user/_user_qr_data.html.twig', ['user' => $user]);
        $qrCode = $qrCodeFactory->create($data);

        return new QrCodeResponse($qrCode);
    }

    /**
     * @Route("/ajax/admin", name="ajax_admin", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function findAdminUser(Request $request)
    {
        $query = $request->get('search');
        $data = $this->repository->findAdmin($query);

        return $this->json($data);
    }

    /**
     * @Route("/remove/user/{id}", name="remove_user")
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function removeUser(User $user)
    {
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovàna');

            return $this->redirectToRoute('list_user');
        } catch (\Exception $exception) {
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

            return $this->redirectToRoute('list_user');
        }
    }
}
