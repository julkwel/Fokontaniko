<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 *
 * @Route("/user")
 */
class UserController extends AbstractBaseController
{
    /**
     * @Route("/new/{user}", name="create_user", methods={"POST","GET"})
     *
     * @param Request   $request
     * @param User|null $user
     *
     * @return Response
     */
    public function newUser(Request $request, User $user = null)
    {
        $user = $user ?? new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->userPassEncoder->encodePassword($user, $user->getPassword()));
            $user->setFokontany($this->getUser() && $this->getUser()->getFokontany() ?
                $this->getUser()->getFokontany() : null);
            $user->setRoles(['ROLE_USER']);

            if ($this->save($user)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i'.$user->getUsername().' nampidirinao!');

                return $this->redirectToRoute('dashboard_home');
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko!');

            return $this->redirectToRoute('create_user', ['user' => $user->getId()]);
        }


        return $this->render('admin/user/_user_form.html.twig',['form'=>$form->createView()]);
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
