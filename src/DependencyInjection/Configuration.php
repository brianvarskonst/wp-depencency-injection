<?php declare(strict_types=1);

namespace Wordpress\DependencyInjection\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('plugin');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->append($this->createFilesystemSection())
            ->end();

        return $treeBuilder;
    }

    private function createFilesystemSection(): ArrayNodeDefinition
    {
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = (new TreeBuilder('filesystem'))->getRootNode();
        $rootNode
            ->children()
            ->arrayNode('private')
            ->performNoDeepMerging()
            ->children()
            ->scalarNode('type')->end()
            ->variableNode('config')->end()
            ->end()
            ->end()
            ->arrayNode('public')
            ->performNoDeepMerging()
            ->children()
            ->scalarNode('type')->end()
            ->variableNode('config')->end()
            ->end()
            ->end()
            ->arrayNode('temp')
            ->performNoDeepMerging()
            ->children()
            ->scalarNode('type')->end()
            ->variableNode('config')->end()
            ->end()
            ->end()
            ->arrayNode('allowed_extensions')
            ->prototype('scalar')->end()
            ->end()
            ->end();

        return $rootNode;
    }

}
