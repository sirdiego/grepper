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
            ->addArgument('output', InputArgument::REQUIRED)
            ->addOption('progress', 'p', InputOption::VALUE_NONE, 'You should only use the progress if every single expression takes some time');
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
        $source = new File($input->getArgument('input'));
        $target = new \SplFileObject($input->getArgument('output'), 'w');

        $progress = null;
        if ($input->getOption('progress')) {
            $source->seek(PHP_INT_MAX);
            $progress = new ProgressBar($output, $source->key());
            $source->rewind();
        }
        $iteration = 0;

        $source->map(function ($buffer) use ($target, &$expression, $progress, &$iteration) {
            if ($progress instanceof ProgressBar && $iteration % 100 == 0) {
                $progress->advance(100);
            }

            $match = preg_match($expression, $buffer);
            if ($match) {
                $target->fwrite($buffer);
            }

            $iteration++;
        });

        if ($progress instanceof ProgressBar) {
            $progress->finish();
        }

        return 0;
    }
}
