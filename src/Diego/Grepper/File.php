<?php
namespace Diego\Grepper;

/**
 * Class File
 */
class File extends \SplFileObject
{
    /**
     * @param callable $callback
     */
    public function map(callable $callback)
    {
        while (!$this->eof()) {
            $buffer = $this->fgets();
            $callback($buffer);
        }
    }
}