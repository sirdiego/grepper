<?php
namespace Diego\Grepper\Command;

use Diego\Grepper\File;
use Diego\Grepper\FileNotFound;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateCommand
 */
class CreateCommand extends AbstractInputFileBasedCommand
{
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('Grep lines from one file and write them to another')
            ->addArgument('input', InputArgument::REQUIRED)
            ->addArgument('expression', InputArgument::REQUIRED)
            ->addArgument('output', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->assureInputFileReadable($input);
        $validLines = new \RegexIterator(new \SplFileObject($input->getArgument('input')), $input->getArgument('expression'));

        $target = new \SplFileObject($input->getArgument('output'), 'w');
        foreach ($validLines as $line) {
            $target->fwrite($line);
        }

        return 0;
    }
}
