<?php

namespace Tomgrohl\Laravel\Auth\Tests\Commands;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Events\Dispatcher;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Illuminate\Foundation\Application;
use Illuminate\Console\Application as ConsoleApplication;
use Tomgrohl\Laravel\Auth\Commands\Hash;

class HashTest extends PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        $hasher = $this->createMock('Illuminate\Contracts\Hashing\Hasher');

        $container = new Application();
        $container->bind('hash', function() use($hasher) {
            return $hasher;
        });

        $hasher->expects($this->once())
            ->method('make')
            ->will($this->returnValue('dfsfsfsdfsdfsf'))
        ;

        $command = new Hash($hasher);
        $commandTest = $this->getCommandTester($command, $container);

        $commandTest->execute(['command' => $command->getName(), 'password' => 'mypassword']);
    }

    /**
     * @param Command $command
     * @return CommandTester
     */
    protected function getCommandTester(Command $command, Application $container)
    {
        $eventDispatcher = new Dispatcher();

        $application = new ConsoleApplication($container, $eventDispatcher, 'version');
        $application->setAutoExit(false);
        $application->add($command);

        $command = $application->find($command->getName());
        $commandTester = new CommandTester($command);

        return $commandTester;
    }
}