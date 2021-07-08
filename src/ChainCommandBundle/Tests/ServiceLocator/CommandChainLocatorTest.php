<?php

namespace App\ChainCommandBundle\Tests\ServiceLocator;

use App\ChainCommandBundle\ServiceLocator\CommandChainLocator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommandChainLocatorTest extends KernelTestCase
{
    private function getChainLocator(): CommandChainLocator
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        return $container->get(CommandChainLocator::class);
    }

    /**
     * @dataProvider \App\ChainCommandBundle\Tests\ServiceLocator\CommandChainLocatorTestDataProvider::getChainCommandsProvider()
     */
    public function testGetChainCommands(string $alias, int $count)
    {
        $this->assertCount($count, $this->getChainLocator()->getChainCommands($alias));
    }

    /**
     * @dataProvider \App\ChainCommandBundle\Tests\ServiceLocator\CommandChainLocatorTestDataProvider::getChainNameByChildProvider()
     */
    public function testGetChainNameByChild(string $alias, string|null $result)
    {
        $this->assertEquals($result, $this->getChainLocator()->getChainNameByChild($alias));
    }
}
