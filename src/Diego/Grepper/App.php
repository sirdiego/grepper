<?php
namespace Diego\Grepper;

use Diego\Grepper\Command\CountCommand;
use Diego\Grepper\Command\CreateCommand;
use Symfony\Component\Console\Application;

/**
 * Class App
 */
class App extends Application
{
    /**
     * App constructor.
     *
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        if ($name === 'UNKNOWN') {
            $name = 'grepper';
        }

        parent::__construct($name, $version);

        $this->addCommands([new CountCommand, new CreateCommand]);
    }
}
