<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Command;

use App\Entity\Fokontany;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Trait CreateFokontanyCommand.
 */
class CreateFokontanyCommand extends Command
{
    /** @var EntityManagerInterface */
    private $entityManager;

    protected static $defaultName = 'app:create:fokontany';

    /**
     * CreateFokontanyCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string|null            $name
     */
    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('Famoronana fokontany iray.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $fokontany = new Fokontany();
        $helper = $this->getHelper('question');

        $name = new Question('Anaran\'ny fokontany : ');
        $code = new Question('Kaodin\'ny fokontany : ');

        $name = $helper->ask($input, $output, $name);
        $code = $helper->ask($input, $output, $code);

        $fokontanyIsExist = $this->entityManager->getRepository(Fokontany::class)->findBy(['name' => $name, 'codeFkt' => $code]);

        if (!empty($fokontanyIsExist)) {
            $symfonyStyle->error('Efa misy io fokontany ampidirinao io!');

            exit(1);
        }

        $fokontany
            ->setName($name)
            ->setCodeFkt($code);

        $this->entityManager->persist($fokontany);
        $this->entityManager->flush();

        $symfonyStyle->note(sprintf('Voaforona ny fokontany %s nampidirinao', $name));
        exit(0);
    }
}
