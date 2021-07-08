<?php

namespace App\ChainCommandBundle\Events;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChainChildDetectedEvent extends ConsoleEvent
{
    public function __construct(Command $command, private Command $child, InputInterface $input, OutputInterface $output)
    {
        parent::__construct($command, $input, $output);
    }

    public function getChildCommand(): Command
    {
        return $this->child;
    }
}
