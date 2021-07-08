<?php

namespace App\ChainCommandBundle\DependencyInjection;

use App\ChainCommandBundle\ServiceLocator\CommandChainLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandChainLocatorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $commandChainsLocator = $container->getDefinition(CommandChainLocator::class);

        foreach ($container->findTaggedServiceIds('app.console.chain') as $id => $tags) {
            foreach ($tags as $attributes) {
                $commandChainsLocator->addMethodCall(
                    'addChainCommand',
                    [
                        new Reference($id),
                        $attributes['parent']
                    ]
                );
            }
        }
    }
}
