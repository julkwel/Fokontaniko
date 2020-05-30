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
use App\Controller\Manager\UserManager;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController.
 *
 * @Route("/user")
 */
class UserController extends AbstractBaseController
{
    /** @var UserManager */
    private $userManager;

    /**
     * UserController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param UserManager                  $userManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, UserManager $userManager)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->userManager = $userManager;
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
            $repository->findPublic(),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/user/_user_list.html.twig', ['users' => $pagination]);
    }

    /**
     * @Route("/new/{id?}", name="manage_user", methods={"POST","GET"})
     *
     * @ParamDecryptor(params={"id"})
     *
     * @param Request   $request
     * @param User|null $user
     *
     * @return Response
     */
    public function manageUser(Request $request, User $user = null)
    {
        $user = $user ?? new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userManager->handleUserBeforePersist($form, $user, $this->getUser());

            if ($this->save($user)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i'.$user->getUsername().' nampidirinao!');

                return $this->redirectToRoute('dashboard_home');
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko!');

            return $this->redirectToRoute('create_user', ['user' => $user->getId()]);
        }


        return $this->render('admin/user/_user_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/remove/{id}", name="user_die", methods={"POST","GET"})
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function removeUser(User $user)
    {
        $user->setIsAlive(false);

        if ($this->save($user)) {
            $this->addFlash();
        }
        $this->addFlash();

        return $this->redirectToRoute('');
    }
}
