<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

/**
 * Class AbstractBaseController.
 */
class AbstractBaseController extends AbstractController
{
    /** @var UrlEncryptor */
    protected $urlEncrypt;

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
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->userPassEncoder = $userPasswordEncoder;
        $this->urlEncrypt = $urlEncrypt;
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
            dd($exception);
            return false;
        }
    }

    /**
     * @param string|null $id to decrypt
     *
     * @return string of the decrypted id
     */
    public function decryptThisId(?string $id)
    {
        return $this->urlEncrypt->decrypt($id);
    }

    /**
     * @param string|null $id to encrypt
     *
     * @return string of encrypted id
     */
    public function encryptThisId(?string $id)
    {
        return $this->urlEncrypt->encrypt($id);
    }
}
