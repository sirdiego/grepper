<?php
namespace Diego\Grepper\Command;

use Diego\Grepper\FileNotFound;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateCommand
 */
class CreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('grep:create')
            ->setDescription('Grep lines from one file and write them to another')
            ->addArgument('input', InputArgument::REQUIRED)
            ->addArgument('expression', InputArgument::REQUIRED)
            ->addArgument('output', InputArgument::REQUIRED);
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
        $outputHandler = new \SplFileObject($input->getArgument('output'), 'w');

        while (!$inputHandler->eof()) {
            $buffer = $inputHandler->fgets();
            $match = preg_match($input->getArgument('expression'), $buffer);
            if ($match) {
                $outputHandler->fwrite($buffer);
            }
        }

        return 0;
    }
}
