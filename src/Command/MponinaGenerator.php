<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Command;

use App\DataFixtures\MponinaFixtures;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MponinaGenerator.
 */
class MponinaGenerator extends Command
{

    protected static $defaultName = 'app:mponina:generator';

    /** @var MponinaFixtures */
    private $mponinaGenerator;

    /**
     * MponinaGenerator constructor.
     *
     * @param MponinaFixtures $fixtures
     * @param string|null     $name
     */
    public function __construct(MponinaFixtures $fixtures, string $name = null)
    {
        parent::__construct($name);
        $this->mponinaGenerator = $fixtures;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->mponinaGenerator->generateMponina($io);

        exit(0);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();
    }
}
