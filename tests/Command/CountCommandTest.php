<?php
namespace Diego\Grepper\Tests\Command;

use Diego\Grepper\Command\CountCommand;

/**
 * Class CountCommandTest
 */
class CountCommandTest extends BaseCommandTestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $command = new CountCommand;
        $this->assertTrue($command instanceof CountCommand);
    }

    /**
     * @test
     */
    public function counts_lines_based_on_regex()
    {
        $name = 'count';
        $tester = $this->setUpCommandTesterFor($name, CountCommand::class);
        $tester->execute(['command' => $name, 'input' => 'vfs://root/input.csv', 'expression' => '/^[0-9]{3}$/']);

        $this->assertRegExp('/Found 2 matches\./', $tester->getDisplay());
    }
}
