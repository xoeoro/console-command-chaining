<?php

namespace App\ChainCommandBundle\Tests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParentCommand extends Command
{
    protected static $defaultName = 'test:chain:parent';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Parent message');

        return Command::SUCCESS;
    }
}
