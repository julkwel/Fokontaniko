<?php
/**
 * @author <Bocasay>.
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Mponina;
use App\Form\MponinaType;
use App\Repository\MponinaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

/**
 * Class MponinaController.
 *
 * @Route("/mponina")
 */
class MponinaController extends AbstractBaseController
{
    private $mponinaRepository;

    /**
     * MponinaController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, MponinaRepository $mponinaRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->mponinaRepository = $mponinaRepository;
    }

    /**
     * @Route("/list", name="mponina_list")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listMponina(Request $request)
    {
        $pagination = $this->paginator->paginate(
            $this->mponinaRepository->findByFokontany($this->getUser()->getFokontany()),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/mponina/_mponina_list.html.twig', ['mponinas' => $pagination]);
    }

    /**
     * @param Request      $request
     * @param Mponina|null $mponina
     *
     * @Route("/manage/{id?}", name="manage_mponina", methods={"POST","GET"})
     *
     * @return Response
     */
    public function manageMponina(Request $request, Mponina $mponina = null)
    {
        $mponina = $mponina ?? new Mponina();
        $form = $this->createForm(MponinaType::class, $mponina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $mponina->setFokontany($this->getUser()->getFokontany());

                $this->save($mponina);
                $this->addFlash(MessageConstant::SUCCESS_TYPE, sprintf('Tafiditra ny %s nampidirinao', $mponina->getFirstName()));

                return $this->redirectToRoute('mponina_list');
            } catch (Exception $exception) {
                $this->addFlash(MessageConstant::ERROR_TYPE, sprintf('Misy olana ny fokontaniko'));

                return $this->redirectToRoute('manage_mponina', ['id' => $mponina->getId()]);
            }
        }

        return $this->render('admin/mponina/_mponina_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/remove/{id?}", name="remove_mponina")
     *
     * @param Mponina $mponina
     *
     * @return RedirectResponse
     */
    public function removeMponina(Mponina $mponina)
    {
        $this->entityManager->remove($mponina);
        $this->entityManager->flush();

        if (($mponina)) {
            $this->addFlash(MessageConstant::SUCCESS_TYPE, sprintf('Voafafa tao amin\'ny lisitrin\'ny mponina i %s ', $mponina->getFirstName()));

            return $this->redirectToRoute('mponina_list');
        }
        $this->addFlash(MessageConstant::ERROR_TYPE, sprintf('Misy olana ny fokontaniko'));

        return $this->redirectToRoute('mponina_list');
    }
}
