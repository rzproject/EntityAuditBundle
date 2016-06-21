<?php

namespace Rz\EntityAuditBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
        $node = $treeBuilder->root('rz_entity_audit');
        $this->addSettingsSection($node);
        return $treeBuilder;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addSettingsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('entity_managers')
                            ->isRequired()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('source')->defaultValue('doctrine.orm.default_entity_manager')->isRequired()->end()
                                ->scalarNode('audit')->defaultValue('doctrine.orm.audit_entity_manager')->isRequired()->end()
                            ->end()
                        ->end()
                        ->arrayNode('audit')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('manager')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue('Rz\\EntityAuditBundle\\Model\\AuditManager')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('reader')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue('Rz\\EntityAuditBundle\\Model\\AuditReader')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('listener')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('log_revisions')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')->defaultValue('Rz\\EntityAuditBundle\\EventListener\\LogRevisionsListener')->end()
                                                ->scalarNode('connection')->defaultValue('default')->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('create_schema')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('class')->defaultValue('Rz\\EntityAuditBundle\\EventListener\\CreateSchemaListener')->end()
                                                ->scalarNode('connection')->defaultValue('audit')->end()
                                            ->end()
                                        ->end()

                                    ->end()
                                ->end()
                                ->arrayNode('config')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue('Rz\\EntityAuditBundle\\Model\\AuditConfiguration')->end()
                                    ->end()
                                ->end()
                            ->end()  #--end audit children
                        ->end() #--end audit
                    ->end()
                ->end()
            ->end();
    }
}
