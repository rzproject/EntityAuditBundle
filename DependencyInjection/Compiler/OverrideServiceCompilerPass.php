<?php

namespace Rz\EntityAuditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $ems = $container->getParameter('rz.entity_audit.entity_managers');
        $doctrineEms = $container->getParameter('doctrine.entity_managers');

        $valid = false;
        foreach ($ems as $key => $value) {
            if (in_array($value, $doctrineEms)) {
                $valid = true;
            } else {
                $valid = false;
                break;
            }
        }

        if ($valid) {

            #####################################
            ## Override Config
            #####################################
            $definition = $container->getDefinition('simplethings_entityaudit.config');
            $definition->setClass($container->getParameter('rz.entity_audit.config.class'));


            #####################################
            ## Override Audit Manager
            #####################################
            $definition = $container->getDefinition('simplethings_entityaudit.manager');
            $definition->setClass($container->getParameter('rz.entity_audit.manager.class'));

            #####################################
            ## Override Audit Reader
            #####################################
            $definition = $container->getDefinition('simplethings_entityaudit.reader');
            $definition->setClass($container->getParameter('rz.entity_audit.reader.class'));

            // if SimpleThingsEntityAudit upgrades to version Symfony 2.8+
            if (method_exists($definition, 'setFactory') && ($definition->getFactoryMethod() === '' || $definition->getFactoryMethod() === null)) {
                $def = new Definition('simplethings_entityaudit.reader', array(new Reference($ems['source']),
                                                                               new Reference($ems['audit'])));
                $def->setClass($container->getParameter('rz.entity_audit.reader.class'));
                $definition->setFactory(array($def, 'createAuditReader'));
            } else {
                $def = new Definition('simplethings_entityaudit.reader', array(new Reference($ems['source']),
                                                                               new Reference($ems['audit'])));
                $def->setClass($container->getParameter('rz.entity_audit.reader.class'));

                //$def->setFactoryClass($container->getParameter('rz.entity_audit.manager.class'));
                $def->setFactoryMethod('createAuditReader');
                $def->setFactoryService('simplethings_entityaudit.manager');
            }

            $container->setDefinition('simplethings_entityaudit.reader', $def);

            #####################################
            ## Override Listeners
            #####################################
            $definition = $container->getDefinition('simplethings_entityaudit.log_revisions_listener');
            $definition->setClass($container->getParameter('rz.entity_audit.listener.log_revisions.class'));
            $definition->addMethodCall('setAuditEm', array(new Reference($ems['audit'])));
            $definition->clearTag('doctrine.event_subscriber');
            $definition->addTag('doctrine.event_subscriber', array('connection' => $container->getParameter('rz.entity_audit.listener.log_revisions.connection')));

            $definition = $container->getDefinition('simplethings_entityaudit.create_schema_listener');
            $definition->setClass($container->getParameter('rz.entity_audit.listener.create_schema.class'));
            $definition->clearTag('doctrine.event_subscriber');
            $definition->addTag('doctrine.event_subscriber', array('connection' => $container->getParameter('rz.entity_audit.listener.create_schema.connection')));

//            $taggedServices = $container->findTaggedServiceIds('doctrine.event_subscriber');
//
//            // Replace tag attribute
//            foreach ($taggedServices as $id => $tags) {
//                if ($id === 'simplethings_entityaudit.log_revisions_listener') {
//                    $definition = $container->getDefinition($id);
//
//                } elseif ($id === 'simplethings_entityaudit.create_schema_listener') {
//                    $definition = $container->getDefinition($id);
//
//                }
//            }
        }
    }
}
