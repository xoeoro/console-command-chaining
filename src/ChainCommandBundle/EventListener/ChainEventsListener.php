<?php

namespace App\ChainCommandBundle\EventListener;

use App\ChainCommandBundle\Events\AfterChainEvent;
use App\ChainCommandBundle\Events\BeforeChainChildrenCommandEvent;
use App\ChainCommandBundle\Events\BeforeChainEvent;
use App\ChainCommandBundle\Events\BeforeChainMasterCommandEvent;
use App\ChainCommandBundle\Events\ChainChildDetectedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChainEventsListener implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function beforeChain(BeforeChainEvent $event): void
    {
        $this->logger->info(sprintf('%s is a master command of a command chain that has registered member commands', $event->getCommand()->getName()));
    }

    public function childDetected(ChainChildDetectedEvent $event): void
    {
        $this->logger->info(sprintf('%s registered as a member of %s command chain', $event->getChildCommand()->getName(), $event->getCommand()->getName()));
    }

    public function beforeMaster(BeforeChainMasterCommandEvent $event): void
    {
        $this->logger->info(sprintf('Executing %s command itself first:', $event->getCommand()->getName()));
    }

    public function beforeChildren(BeforeChainChildrenCommandEvent $event): void
    {
        $this->logger->info(sprintf('Executing %s chain members:', $event->getCommand()->getName()));
    }

    public function afterChain(AfterChainEvent $event): void
    {
        $this->logger->info(sprintf('Execution of %s chain completed.', $event->getCommand()->getName()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeChainEvent::class => 'beforeChain',
            ChainChildDetectedEvent::class => 'childDetected',
            BeforeChainMasterCommandEvent::class => 'beforeMaster',
            BeforeChainChildrenCommandEvent::class => 'beforeChildren',
            AfterChainEvent::class => 'afterChain',
        ];
    }
}
