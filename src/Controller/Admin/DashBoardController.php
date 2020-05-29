<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
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
     * @Route("/dashboard",name="dashboard_home", methods={"GET"})
     */
    public function dashboardHome()
    {
        return $this->render('admin/dashboard/_dashboard_home.html.twig');
    }
}
