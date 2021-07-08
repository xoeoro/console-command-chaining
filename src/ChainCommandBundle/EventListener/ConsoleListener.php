<?php

namespace App\ChainCommandBundle\EventListener;

use App\ChainCommandBundle\Events\AfterChainEvent;
use App\ChainCommandBundle\Events\BeforeChainChildrenCommandEvent;
use App\ChainCommandBundle\Events\BeforeChainEvent;
use App\ChainCommandBundle\Events\BeforeChainMasterCommandEvent;
use App\ChainCommandBundle\Events\ChainChildDetectedEvent;
use App\ChainCommandBundle\ServiceLocator\CommandChainLocator;
use App\ChainCommandBundle\Exception\ChainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleListener implements EventSubscriberInterface
{
    public function __construct(private CommandChainLocator $chains, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @param ConsoleCommandEvent $event
     * @throws ChainException
     */
    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();

        if ($chain = $this->chains->getChainNameByChild($command->getName())) {
            $event->stopPropagation();
            $event->disableCommand();

            throw new ChainException(
                sprintf(
                    'Error: %s command is a member of %s command chain and cannot be executed on its own.',
                    $command->getName(),
                    $chain
                )
            );
        }

        if ($chainCommands = $this->chains->getChainCommands($command->getName())) {
            $this->eventDispatcher->dispatch(new BeforeChainEvent($command, $event->getInput(), $event->getOutput()));

            foreach ($chainCommands as $child) {
                $this->eventDispatcher->dispatch(new ChainChildDetectedEvent($command, $child, $event->getInput(), $event->getOutput()));
            }

            $this->eventDispatcher->dispatch(new BeforeChainMasterCommandEvent($command, $event->getInput(), $event->getOutput()));
        }
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        $command = $event->getCommand();

        if ($chainCommands = $this->chains->getChainCommands($command->getName())) {
            $output = $event->getOutput();

            $this->eventDispatcher->dispatch(new BeforeChainChildrenCommandEvent($command, $event->getInput(), $event->getOutput()));

            array_walk($chainCommands, fn(Command $chainCommand) => $chainCommand->run(new ArrayInput([]), $output));

            $this->eventDispatcher->dispatch(new AfterChainEvent($command, $event->getInput(), $event->getOutput()));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }
}
