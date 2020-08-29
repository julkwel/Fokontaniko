<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    /** @var PaginatorInterface */
    protected $paginator;

    /**
     * AbstractBaseController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param PaginatorInterface           $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->userPassEncoder = $userPasswordEncoder;
        $this->paginator = $paginator;
    }

    /**
     * Save entity object | persist object if id is null (new object)
     *  Always flush the entityManager whatever the state of this action
     *
     * @param object $object will save
     *
     * @return bool $success the status of this action
     */
    public function save(object $object)
    {
        try {
            if (!$object->getId()) {
                $this->entityManager->persist($object);
            }
            $this->entityManager->flush();

            return true;
        } catch (\Exception $exception) {
//            dd($exception);
            return false;
        }
    }
}
