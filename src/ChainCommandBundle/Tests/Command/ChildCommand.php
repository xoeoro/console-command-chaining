<?php

namespace App\ChainCommandBundle\Tests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.console.chain', ['parent' => 'test:chain:parent'])]
class ChildCommand extends Command
{
    protected static $defaultName = 'test:chain:child';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Child message');

        return Command::SUCCESS;
    }
}
