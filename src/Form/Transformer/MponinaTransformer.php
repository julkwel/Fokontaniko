<?php
/**
 * @author <Bocasay>.
 */

namespace App\Form\Transformer;

use App\Entity\Mponina;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class MponinaTransformer.
 */
class MponinaTransformer implements DataTransformerInterface
{
    private $entityManager;

    /**
     * MponinaTransformer constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param Mponina $mponina
     *
     * @return string
     */
    public function transform($mponina)
    {
        if (null === $mponina) {
            return '';
        }

        return $mponina->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param $mponinaId
     *
     * @return Mponina|null
     */
    public function reverseTransform($mponinaId)
    {
        if (!$mponinaId) {
            return;
        }

        $related = $this->entityManager
            ->getRepository(Mponina::class)
            ->find($mponinaId);

        if (!$related) {
            throw new TransformationFailedException(sprintf(
                'Ny olona "%s" dia tsy mbola misy!',
                $mponinaId
            ));
        }

        return $related;
    }
}
