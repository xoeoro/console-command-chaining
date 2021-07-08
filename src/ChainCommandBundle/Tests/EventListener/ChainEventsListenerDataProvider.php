<?php

namespace App\ChainCommandBundle\Tests\EventListener;

use App\ChainCommandBundle\Events\AfterChainEvent;
use App\ChainCommandBundle\Events\BeforeChainChildrenCommandEvent;
use App\ChainCommandBundle\Events\BeforeChainEvent;
use App\ChainCommandBundle\Events\BeforeChainMasterCommandEvent;
use App\ChainCommandBundle\Events\ChainChildDetectedEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class ChainEventsListenerDataProvider
{
    public static function beforeChainDataProvider(): array
    {
        return [
            [
                new BeforeChainEvent(new Command('test:parent'), new StringInput(''), new NullOutput()),
                'test:parent is a master command of a command chain that has registered member commands'
            ]
        ];
    }
    public static function childDetectedDataProvider(): array
    {
        return [
            [
                new ChainChildDetectedEvent(new Command('test:parent'), new Command('test:child'), new StringInput(''), new NullOutput()),
                'test:child registered as a member of test:parent command chain'
            ]
        ];
    }
    public static function beforeMasterDataProvider(): array
    {
        return [
            [
                new BeforeChainMasterCommandEvent(new Command('test:parent'), new StringInput(''), new NullOutput()),
                'Executing test:parent command itself first:'
            ]
        ];
    }
    public static function beforeChildrenDataProvider(): array
    {
        return [
            [
                new BeforeChainChildrenCommandEvent(new Command('test:parent'), new StringInput(''), new NullOutput()),
                'Executing test:parent chain members:'
            ]
        ];
    }
    public static function afterChainDataProvider(): array
    {
        return [
            [
                new AfterChainEvent(new Command('test:parent'), new StringInput(''), new NullOutput()),
                'Execution of test:parent chain completed.'
            ]
        ];
    }
}
