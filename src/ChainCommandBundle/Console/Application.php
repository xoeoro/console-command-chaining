<?php

namespace App\ChainCommandBundle\Console;

use App\ChainCommandBundle\Output\OutputLogDecorator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getKernel()->getContainer()->get('logger');
        $output = new OutputLogDecorator($output, $logger);

        return parent::doRunCommand($command, $input, $output);
    }
}
