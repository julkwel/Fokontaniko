<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class LaunchCommandTest.
 */
class LaunchCommandTest extends KernelTestCase
{
    /**
     * Execute command insert faker mponina
     */
    public function testExecute()
    {
        $kernel = static::createKernel();
        $app = new Application($kernel);

        $command = $app->find('app:mponina:generator');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);
    }

    /**
     * Test the execution of command insert fokontany
     */
    public function testCreateFokontany()
    {
        $kernel = static::createKernel();
        $app = new Application($kernel);

        $command = $app->find('app:create:fokontany');
        $commandTester = new CommandTester($command);

        $commandTester->setInputs(['Test', 'Test2']);
        $commandTester->execute(['command' => $command->getName()]);
    }
}
