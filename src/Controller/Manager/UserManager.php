<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Manager.
 */

namespace App\Controller\Manager;

use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager.
 */
class UserManager
{
    /** @var UserPasswordEncoderInterface */
    private $passEncoder;

    /**
     * UserManager constructor.
     *
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->passEncoder = $userPasswordEncoder;
    }

    /**
     * @param User   $user
     * @param string $password
     *
     * @return string
     */
    public function encodeUserPassword(User $user, string $password)
    {
        return $this->passEncoder->encodePassword($user, $password);
    }

    /**
     * @param FormInterface $form        current form to get password
     * @param User          $user        to manage
     * @param User|null     $currentUser the connected user
     * @param bool|null     $isPublic    is the user is public
     *
     * @return User will save
     */
    public function handleUserBeforePersist(FormInterface $form, User $user, ?User $currentUser, ?bool $isPublic = true)
    {
        if (!empty($form->get('password')->getData())) {
            $user->setPassword($form->get('password')->getData());
        }

        $user->setPassword($this->encodeUserPassword($user, $user->getPassword()));
        $user->setFokontany($currentUser && $currentUser->getFokontany() ?
            $currentUser->getFokontany() : null);
        $user->setRoles($isPublic ? ['ROLE_USER'] : ['ROLE_EM_FKT']);

        return $user;
    }
}
