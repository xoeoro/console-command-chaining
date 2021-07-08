<?php

namespace App\ChainCommandBundle\Tests\Command;

use App\ChainCommandBundle\Exception\ChainException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class ChildCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $this->expectException(ChainException::class);
        $this->expectExceptionMessage('Error: test:chain:child command is a member of test:chain:parent command chain and cannot be executed on its own.');

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $application->run(new StringInput('test:chain:child'), new NullOutput());
    }
}
