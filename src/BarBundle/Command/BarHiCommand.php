<?php

namespace App\BarBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.console.chain', ['parent' => 'foo:hello'])]
class BarHiCommand extends Command
{
    protected static $defaultName = 'bar:hi';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hi from Bar!');

        return Command::SUCCESS;
    }
}
