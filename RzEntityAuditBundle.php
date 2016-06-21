<?php

namespace Rz\EntityAuditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Rz\EntityAuditBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class RzEntityAuditBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }
}
