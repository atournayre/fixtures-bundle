<?php

namespace Atournayre\Bundle\FixtureBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('atournayre_fixture');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('command')->defaultValue('hautelook:fixtures:load')->end()
                ->scalarNode('ending_message')->defaultValue('Fixtures are loaded, <info>no more actions required</info>. Enjoy!')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
