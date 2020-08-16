<?php
/**
 * @author <Bocasay>.
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AbstractManager.
 */
abstract class AbstractManager
{
    /** @var UserPasswordEncoderInterface */
    protected $passEncoder;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * AbstractManager constructor.
     *
     * @param UserPasswordEncoderInterface $passEncoder
     * @param EntityManagerInterface       $entityManager
     */
    public function __construct(UserPasswordEncoderInterface $passEncoder, EntityManagerInterface $entityManager)
    {
        $this->passEncoder = $passEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function save($object)
    {
        try {
            if (!$object->getId()) {
                $this->entityManager->persist($object);
            }
            $this->entityManager->flush();

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
