<?php
/**
 * @author <Bocasay>.
 */

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashBoardController.
 */
class DashBoardController extends AbstractBaseController
{
    /**
     * @Route("/admin",name="dashboard_home", methods={"GET"})
     */
    public function dashboardHome()
    {
        return $this->render('admin/Dashboard/_dashboard_home.html.twig');
    }
}
