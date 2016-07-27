<?php
namespace Diego\Grepper\Command;

use Diego\Grepper\FileNotFound;
use Diego\Grepper\FileNotReadable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class AbstractInputFileBasedCommand
 */
abstract class AbstractInputFileBasedCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param string $argumentName
     * @throws FileNotFound
     * @throws FileNotReadable
     */
    protected function assureInputFileReadable(InputInterface $input, $argumentName = 'input')
    {
        if (!file_exists($input->getArgument($argumentName))) {
            throw new FileNotFound('File \'' . $input->getArgument($argumentName) . '\' not found.');
        }

        if (!is_readable($input->getArgument($argumentName))) {
            throw new FileNotReadable('File \'' . $input->getArgument($argumentName) . '\' not readable');
        }
    }
}