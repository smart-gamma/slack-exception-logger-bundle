<?php

namespace Dopiaza\Slack\ExceptionLoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dopiaza_slack_exception_logger');

        $rootNode
            ->children()

                ->scalarNode('webhook')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()

            ->scalarNode('name')
                ->isRequired()
                ->cannotBeEmpty()
            ->end()

            ->scalarNode('botname')
            ->end()

            ->arrayNode('environments')
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                            // need to read from env https://github.com/symfony/symfony/issues/24015
                            ->scalarNode('enabled')->defaultValue('true')->end()
                            ->scalarNode('color')->defaultValue('danger')->end()
                            ->scalarNode('channel')->isRequired()->end()
                            ->arrayNode('exclude_exception')->prototype('scalar')->end()
                        ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
