<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\EventListener;

use App\Constant\HistoryConstant;
use App\Entity\History;
use App\Entity\Mponina;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class History.
 */
class HistoryListner
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * HistoryListner constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Mponina) {
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $history = new History();

        $action = sprintf('Nampiditra an\'i %s i %s', $entity->getFirstName(), $user->getUsername());
        $history->setType(array_flip(HistoryConstant::HISTORY_TYPE)['Add']);

        $entityManager = $args->getObjectManager();
        $history
            ->setFokontany($user->getFokontany())
            ->setUser($user)
            ->setAction($action);

        $entityManager->persist($history);
        $entityManager->flush($history);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Mponina) {
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $history = new History();

        $action = sprintf('Nanova an\'i %s i %s', $entity->getFirstName(), $user->getUsername());
        $entityManager = $args->getObjectManager();
        $history
            ->setFokontany($user->getFokontany())
            ->setUser($user)
            ->setType(array_flip(HistoryConstant::HISTORY_TYPE)['Edit'])
            ->setAction($action);

        $entityManager->persist($history);
        $entityManager->flush($history);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Mponina) {
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $action = sprintf('Nofafan\'i %s i %s', $user->getUsername(), $entity->getFirstName());

        $entityManager = $args->getObjectManager();
        $history = new History();
        $history
            ->setFokontany($user->getFokontany())
            ->setUser($user)
            ->setAction($action)
            ->setType(array_flip(HistoryConstant::HISTORY_TYPE)['Delete']);

        $entityManager->persist($history);
        $entityManager->flush($history);
    }
}
