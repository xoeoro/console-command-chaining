<?php

namespace App\ChainCommandBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ParentCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $output = new BufferedOutput();
        $application->run(new StringInput('test:chain:parent'), $output);

        $this->assertEquals("Parent message\nChild message\n", $output->fetch());
    }
}
