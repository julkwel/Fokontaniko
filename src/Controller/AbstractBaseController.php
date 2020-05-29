<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AbstractBaseController.
 */
class AbstractBaseController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var UserPasswordEncoderInterface */
    protected $userPassEncoder;

    /**
     * AbstractBaseController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPassEncoder = $userPasswordEncoder;
    }

    /**
     * Save entity object | persist object if id is null (new object)
     *  Always flush the entityManager whatever the state of this action
     *
     * @param object $object the object to save
     *
     * @return bool $success the status of this action
     */
    public function save(object $object)
    {
        $success = false;
        try {
            if (!$object->getId()) {
                $this->entityManager->persist($object);
            }
            $success = true;
        } catch (\Exception $exception) {
            $success = false;
        } finally {
            $this->entityManager->flush();
        }

        return $success;
    }
}
