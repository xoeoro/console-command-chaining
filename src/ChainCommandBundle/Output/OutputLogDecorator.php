<?php

namespace App\ChainCommandBundle\Output;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutputLogDecorator implements OutputInterface
{
    public function __construct(private OutputInterface $output, private LoggerInterface $logger)
    {
    }

    protected function doWrite(string $message, bool $newline)
    {
        $this->output->doWrite($message, $newline);
    }

    public function isDebug()
    {
        return $this->output->isDebug();
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        $this->output->setFormatter($formatter);
    }

    public function isVerbose()
    {
        return $this->output->isVerbose();
    }

    public function isVeryVerbose()
    {
        return $this->output->isVeryVerbose();
    }

    public function write($messages, $newline = false, $options = 0)
    {
        $this->output->write($messages, $newline, $options);

        $this->logger->info($messages);
    }

    public function writeln($messages, $options = 0)
    {
        $this->output->writeln($messages, $options);

        $this->logger->info($messages);
    }

    public function setVerbosity($level)
    {
        $this->output->setVerbosity($level);
    }

    public function getVerbosity()
    {
        return $this->output->getVerbosity();
    }

    public function setDecorated($decorated)
    {
        $this->output->setDecorated($decorated);
    }

    public function isDecorated()
    {
        return $this->output->isDecorated();
    }

    public function getFormatter()
    {
        return $this->output->getFormatter();
    }

    public function isQuiet()
    {
        return $this->output->isQuiet();
    }
}
