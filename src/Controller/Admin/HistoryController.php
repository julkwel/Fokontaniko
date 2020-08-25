<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Controller\Admin;

use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Repository\HistoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HistoryController.
 *
 * @Route("/admin")
 */
class HistoryController extends AbstractBaseController
{
    /**
     * @Route("/history/list")
     *
     * @param Request           $request
     * @param HistoryRepository $historyRepository
     *
     * @return Response
     */
    public function historyList(Request $request, HistoryRepository $historyRepository)
    {
        $pagination = $this->paginator->paginate(
            $historyRepository->findHistoryByFokontany($this->getUser()->getFokontany()),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/menu/template/_history_template.html.twig', ['historys' => $pagination]);
    }
}
