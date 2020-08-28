<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller\Front;

use App\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FrontController.
 */
class FrontController extends AbstractBaseController
{
    /**
     * @Route("/", name="front_home", methods={"POST","GET"})
     *
     * @return Response
     */
    public function home()
    {
        return $this->render('front/_index.html.twig');
    }
}
