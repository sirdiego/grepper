<?php
namespace Diego\Grepper\Tests\Command;

use Diego\Grepper\Command\CreateCommand;

/**
 * Class CreateCommandTest
 */
class CreateCommandTest extends BaseCommandTestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $command = new CreateCommand;
        $this->assertTrue($command instanceof CreateCommand);
    }

    /**
     * @test
     */
    public function counts_lines_based_on_regex()
    {
        $name = 'create';
        $tester = $this->setUpCommandTesterFor($name, CreateCommand::class);
        $tester->execute(['command' => $name, 'input' => 'vfs://root/input.csv', 'expression' => '/^[0-9]{3}$/', 'output' => 'vfs://root/output.csv']);

        $this->assertEquals("123\n456\n", file_get_contents('vfs://root/output.csv'));
    }
}