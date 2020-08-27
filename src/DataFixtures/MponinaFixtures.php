<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\DataFixtures;

use App\Entity\Fokontany;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use App\Entity\Mponina;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MponinaFixtures.
 */
class MponinaFixtures
{
    private $entityManager;

    /**
     * MponinaFixtures constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generate fake 100 mponina
     *
     * @param SymfonyStyle $symfonyStyle
     */
    public function generateMponina(SymfonyStyle $symfonyStyle)
    {
        $pb = $symfonyStyle->createProgressBar(200);

        $pb->start(0);
        $faker = Factory::create('fr_FR');
        $fokontany = $this->entityManager->getRepository(Fokontany::class)->findAll();

        if (!empty($fokontany)) {
            for ($i = 0; $i < 200; $i++) {
                $mponina = new Mponina();
                $mponina->setIsAlive(true)
                    ->setType(rand(0, 2))
                    ->setGenres(rand(1, 2))
                    ->setAdresse($faker->address)
                    ->setBirthDate($faker->dateTime('now'))
                    ->setCin($faker->isbn13)
                    ->setContact($faker->phoneNumber)
                    ->setDad($faker->firstNameMale)
                    ->setMum($faker->firstNameFemale)
                    ->setFunction($faker->jobTitle)
                    ->setNote($faker->text)
                    ->setLastName($faker->lastName)
                    ->setFirstName($faker->firstName)
                    ->setFokontany($fokontany[array_rand($fokontany)]);

                $this->entityManager->persist($mponina);
                $this->entityManager->flush();
                $pb->advance($i);
            }
        }

        $pb->finish();
    }
}
