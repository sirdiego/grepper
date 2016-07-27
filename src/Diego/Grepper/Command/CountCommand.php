<?php
namespace Diego\Grepper\Command;

use Diego\Grepper\FileNotFound;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CountCommand
 */
class CountCommand extends Command
{
    protected function configure()
    {
        $this->setName('grep:create')
            ->setDescription('Grep lines from one file counts the matches')
            ->addArgument('input', InputArgument::REQUIRED)
            ->addArgument('expression', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws FileNotFound
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists($input->getArgument('input'))) {
            throw new FileNotFound('File \'' . $input->getArgument('input') . '\' not found.');
        }

        $inputHandler = new \SplFileObject($input->getArgument('input'));

        $count = 0;

        while (!$inputHandler->eof()) {
            $buffer = $inputHandler->fgets();
            $match = preg_match($input->getArgument('expression'), $buffer);
            if ($match) {
                $count++;
            }
        }

        $output->write('Found ' . $count . ' matches.' . PHP_EOL);

        return 0;
    }
}