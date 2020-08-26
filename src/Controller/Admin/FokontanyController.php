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
use App\Entity\Fokontany;
use App\Entity\User;
use App\Form\FokontanyType;
use App\Repository\FokontanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class FokontanyController.
 *
 * @Route("/admin/fokontany")
 */
class FokontanyController extends AbstractBaseController
{
    /** @var FokontanyRepository */
    private $repository;

    /**
     * FokontanyController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param FokontanyRepository          $fokontanyRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, FokontanyRepository $fokontanyRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->repository = $fokontanyRepository;
    }

    /**
     * @Route("/manage/{id?}", name="fokontany_manage", methods={"POST","GET"})
     *
     * @param Request        $request
     * @param Fokontany|null $fokontany
     *
     * @return RedirectResponse|Response
     */
    public function manageFokontany(Request $request, Fokontany $fokontany = null)
    {
        $fokontany = $fokontany ?? new Fokontany();
        $form = $this->createForm(FokontanyType::class, $fokontany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($fokontany)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra ny fokontany nampidirinao');

                return $this->redirectToRoute('fokontany_list');
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

            return $this->redirectToRoute('fokontany_manage', ['id' => $fokontany->getId()]);
        }

        return $this->render('admin/fokontany/_fokontany_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/list", name="fokontany_list", methods={"POST","GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fokontanyList(Request $request)
    {
        $needle = $request->get('search');
        $pagination = $this->paginator->paginate(
            $this->repository->findAllFokontany($needle),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/fokontany/_fokontany_list.html.twig', ['fokontanys' => $pagination]);
    }

    /**
     * @Route("/remove/{id}", name="remove_fokontany")
     *
     * @param Fokontany $fokontany
     *
     * @return RedirectResponse
     */
    public function removeFokontany(Fokontany $fokontany)
    {
        try {
            $this->entityManager->remove($fokontany);
            $this->entityManager->flush();

            $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovana');

            return $this->redirectToRoute('fokontany_list');
        } catch (\Exception $exception) {
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

            return $this->redirectToRoute('fokontany_list');
        }
    }

    /**
     * @Route("/responsable/{id}", name="fokontany_responsable", methods={"POST","GET"})
     *
     * @param Request   $request
     * @param Fokontany $fokontany
     *
     * @return Response
     */
    public function addResponsable(Request $request, Fokontany $fokontany)
    {
        if ('POST' === $request->getMethod()) {
            /** @var User $user */
            $user = $this->entityManager->getRepository(User::class)->find($request->get('username'));

            /** @var Employee $responsable */
            $responsable = $this->entityManager->getRepository(Employee::class)->findOneBy(['user' => $user]) ?? new Employee();
            $user->setFokontany($fokontany);

            $responsable
                ->setFokontany($fokontany)
                ->setPost('Chef fokontany');

            if ($fokontany) {
                $fokontany->addResponsable($responsable);

                if ($this->save($fokontany)) {
                    $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovana');

                    return $this->redirectToRoute('fokontany_list');
                }
                $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

                return $this->redirectToRoute('fokontany_responsable', ['id' => $fokontany->getId()]);
            }

        }

        return $this->render('admin/fokontany/_fokontany_responsable.html.twig', ['fokontany' => $fokontany]);
    }
}
