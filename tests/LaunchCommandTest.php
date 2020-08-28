<?php
/**
 * @author Julkwel <julienrajerison5@gmail.com>.
 *
 * Fokontaniko project 2020
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class LaunchCommandTest.
 */
class LaunchCommandTest extends WebTestCase
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
}
