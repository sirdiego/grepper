<?php
namespace Diego\Grepper\Tests\Command;

use Diego\Grepper\App;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class BaseCommandTestCase
 */
abstract class BaseCommandTestCase extends TestCase
{
    public function setUp()
    {
        vfsStream::setup('root', null, [
            'input.csv' => '123' . PHP_EOL . '456' . PHP_EOL . 'asdf',
            'output.csv' => ''
        ]);
    }

    /**
     * @param string $name
     * @param Command $class
     *
     * @return CommandTester
     */
    public function setUpCommandTesterFor($name, $class)
    {
        $app = new App;
        $command = new $class;
        $command->setApplication($app);
        $command = $app->find($name);

        $tester = new CommandTester($command);
        return $tester;
    }
}
