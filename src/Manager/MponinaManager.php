<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Manager;

use App\Repository\MponinaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class MponinaManager.
 */
class MponinaManager extends AbstractManager
{
    /** @var MponinaRepository */
    private $mponinaRepository;

    /**
     * MponinaManager constructor.
     *
     * @param UserPasswordEncoderInterface $passEncoder
     * @param EntityManagerInterface       $entityManager
     * @param MponinaRepository            $mponinaRepository
     */
    public function __construct(UserPasswordEncoderInterface $passEncoder, EntityManagerInterface $entityManager, MponinaRepository $mponinaRepository)
    {
        parent::__construct($passEncoder, $entityManager);
        $this->mponinaRepository = $mponinaRepository;
    }
}
