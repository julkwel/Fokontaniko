<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Command.
 */

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class FokontanyUserCommand.
 */
class FokontanyUserCommand extends Command
{
    /** @var UserPasswordEncoderInterface */
    private $passEncoder;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * FokontanyUserCommand constructor.
     *
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param EntityManagerInterface       $entityManager
     * @param string|null                  $name
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->passEncoder = $userPasswordEncoder;
        $this->em = $entityManager;
    }

    protected static $defaultName = 'app:create:user';

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Famoronana mpiandraikitra ny fokontaniko')
            ->addArgument('username', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('u', null, InputOption::VALUE_NONE, 'Anarana')
            ->addOption('p', null, InputOption::VALUE_NONE, 'Teny miafina');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = new User();
        $helper = $this->getHelper('question');

        $username = new Question('Anarana fidirana : ');
        $password = new Question('Teny miafina : ');
        $firstname = new Question('Anarana : ');
        $lastname = new Question('Fanampiny : ');
        $addr = new Question('Adiresy : ');
        $contact = new Question('Finday : ');

        $user->setUserName($helper->ask($input, $output, $username));
        $user->setPassword($this->passEncoder->encodePassword($user, $helper->ask($input, $output, $password)));
        $user->setFirstName($helper->ask($input, $output, $firstname));
        $user->setLastName($helper->ask($input, $output, $lastname));
        $user->setAdresse($helper->ask($input, $output, $addr));
        $user->setContact($helper->ask($input, $output, $contact));
        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $this->em->persist($user);
        $this->em->flush();

        $io->success('Tafiditra ny'.$user->getFirstName().' nampidirinao');

        return 0;
    }
}
