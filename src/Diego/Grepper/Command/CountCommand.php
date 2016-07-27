<?php
namespace Diego\Grepper\Command;

use Diego\Grepper\File;
use Diego\Grepper\FileNotFound;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CountCommand
 */
class CountCommand extends AbstractInputFileBasedCommand
{
    protected function configure()
    {
        $this->setName('count')
            ->setDescription('Grep lines from a file and counts the matches')
            ->addArgument('input', InputArgument::REQUIRED)
            ->addArgument('expression', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->assureInputFileReadable($input);

        $expression = $input->getArgument('expression');
        $count = 0;
        $source = new File($input->getArgument('input'));
        $source->map(function ($buffer) use (&$count, &$expression) {
            $match = preg_match($expression, $buffer);
            if ($match) {
                $count++;
            }
        });

        $output->write('Found ' . $count . ' matches.' . PHP_EOL);

        return 0;
    }
}