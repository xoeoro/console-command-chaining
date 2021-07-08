<?php

namespace App\ChainCommandBundle\Tests\ServiceLocator;

class CommandChainLocatorTestDataProvider
{
    public static function getChainCommandsProvider(): array
    {
        return [
            ['test:chain:child', 0],
            ['test:chain:parent', 1],
        ];
    }


    public static function getChainNameByChildProvider(): array
    {
        return [
            ['test:chain:child', 'test:chain:parent'],
            ['test:chain:parent', null],
        ];
    }
}
