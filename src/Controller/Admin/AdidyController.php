<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Adidy;
use App\Entity\Mponina;
use App\Form\AdidyType;
use App\Repository\AdidyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdidyController.
 *
 * @Route("/admin/adidy")
 */
class AdidyController extends AbstractBaseController
{
    /** @var AdidyRepository */
    private $repository;

    /**
     * AdidyController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param AdidyRepository              $adidyRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, AdidyRepository $adidyRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->repository = $adidyRepository;
    }

    /**
     * @Route("/list/{id}", name="list_adidy")
     *
     * @param Request $request
     * @param Mponina $mponina
     *
     * @return Response
     */
    public function listAdidy(Request $request, Mponina $mponina)
    {
        $pagination = $this->paginator->paginate(
            $this->repository->listAdidy($mponina),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/adidy/_adidy_list.html.twig', ['adidys' => $pagination, 'user' => $mponina]);
    }

    /**
     * @Route("/manage/{mponina}/{adidy?}", name="manage_adidy")
     *
     * @param Request    $request
     * @param Mponina    $mponina
     * @param Adidy|null $adidy
     *
     * @return Response
     */
    public function manageAdidy(Request $request, Mponina $mponina, ?Adidy $adidy = null)
    {
        $adidy = $adidy ?? new Adidy();
        $form = $this->createForm(AdidyType::class, $adidy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adidy->setUser($mponina)->setIsPaid(true);
            if ($this->save($adidy)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra ny adidy nampidirinao hoan\'i'.$adidy->getUser()->getFullName().' !');

                return $this->redirectToRoute('list_adidy', ['id' => $mponina->getId()]);
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ity application ity, manasa anao hamerina indray !');

            return $this->redirectToRoute('manage_adidy', ['mponina' => $mponina->getId(), 'adidy' => $adidy->getId()]);
        }

        return $this->render('admin/adidy/_adidy_form.html.twig', ['form' => $form->createView(), 'user' => $mponina]);
    }
}
