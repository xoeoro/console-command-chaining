<?php

namespace App\ChainCommandBundle\Tests\EventListener;

use App\ChainCommandBundle\EventListener\ChainEventsListener;
use App\ChainCommandBundle\Events\AfterChainEvent;
use App\ChainCommandBundle\Events\BeforeChainChildrenCommandEvent;
use App\ChainCommandBundle\Events\BeforeChainEvent;
use App\ChainCommandBundle\Events\BeforeChainMasterCommandEvent;
use App\ChainCommandBundle\Events\ChainChildDetectedEvent;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChainEventsListenerTest extends KernelTestCase
{
    private ChainEventsListener $listener;
    private string $collectedMessage = '';

    protected function mockLogger(): MockObject|Logger
    {
        $logger = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects($this->any())
            ->method('info')
            ->will(
                $this->returnCallback(
                    function ($message) {
                        $this->collectedMessage = $message;
                    }
                )
            );

        return $logger;
    }

    public function setUp(): void
    {
        $this->listener = new ChainEventsListener($this->mockLogger());
    }

    /**
     * @param BeforeChainEvent $event
     * @param string $expectedMessage
     * @dataProvider \App\ChainCommandBundle\Tests\EventListener\ChainEventsListenerDataProvider::beforeChainDataProvider()
     */
    public function testBeforeChainEvent(BeforeChainEvent $event, string $expectedMessage)
    {
        $this->listener->beforeChain($event);
        $this->assertEquals($expectedMessage, $this->collectedMessage);
    }

    /**
     * @param ChainChildDetectedEvent $event
     * @param string $expectedMessage
     * @dataProvider \App\ChainCommandBundle\Tests\EventListener\ChainEventsListenerDataProvider::childDetectedDataProvider()
     */
    public function testChildDetectedEvent(ChainChildDetectedEvent $event, string $expectedMessage)
    {
        $this->listener->childDetected($event);
        $this->assertEquals($expectedMessage, $this->collectedMessage);
    }

    /**
     * @param BeforeChainMasterCommandEvent $event
     * @param string $expectedMessage
     * @dataProvider \App\ChainCommandBundle\Tests\EventListener\ChainEventsListenerDataProvider::beforeMasterDataProvider()
     */
    public function testBeforeMasterEvent(BeforeChainMasterCommandEvent $event, string $expectedMessage)
    {
        $this->listener->beforeMaster($event);
        $this->assertEquals($expectedMessage, $this->collectedMessage);
    }

    /**
     * @param BeforeChainChildrenCommandEvent $event
     * @param string $expectedMessage
     * @dataProvider \App\ChainCommandBundle\Tests\EventListener\ChainEventsListenerDataProvider::beforeChildrenDataProvider()
     */
    public function testBeforeChildrenEvent(BeforeChainChildrenCommandEvent $event, string $expectedMessage)
    {
        $this->listener->beforeChildren($event);
        $this->assertEquals($expectedMessage, $this->collectedMessage);
    }

    /**
     * @param AfterChainEvent $event
     * @param string $expectedMessage
     * @dataProvider \App\ChainCommandBundle\Tests\EventListener\ChainEventsListenerDataProvider::afterChainDataProvider()
     */
    public function testAfterChainEvent(AfterChainEvent $event, string $expectedMessage)
    {
        $this->listener->afterChain($event);
        $this->assertEquals($expectedMessage, $this->collectedMessage);
    }

    public function testGetSubscribedEvents()
    {
        $this->assertEquals(
            [
                BeforeChainEvent::class => 'beforeChain',
                ChainChildDetectedEvent::class => 'childDetected',
                BeforeChainMasterCommandEvent::class => 'beforeMaster',
                BeforeChainChildrenCommandEvent::class => 'beforeChildren',
                AfterChainEvent::class => 'afterChain',
            ],
            $this->listener::getSubscribedEvents()
        );
    }
}
