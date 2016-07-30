<?php

namespace Rz\EntityAuditBundle\Model;

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Rz\EntityAudit\EventListener\CreateSchemaListener;
use Rz\EntityAudit\EventListener\LogRevisionsListener;

/**
 * Audit Manager grants access to metadata and configuration
 * and has a factory method for audit queries.
 */
class AuditManager
{
    protected $config;

    protected $metadataFactory;

    /**
     * @param AuditConfiguration $config
     */
    public function __construct(AuditConfiguration $config)
    {
        $this->config = $config;
        $this->metadataFactory = $config->createMetadataFactory();
    }

    public function getMetadataFactory()
    {
        return $this->metadataFactory;
    }

    public function getConfiguration()
    {
        return $this->config;
    }

    public function createAuditReader(EntityManager $sourceEm, EntityManager $auditEm)
    {
        return new AuditReader($sourceEm, $auditEm, $this->config, $this->metadataFactory);
    }

    public function registerEvents(EventManager $evm)
    {
        $evm->addEventSubscriber(new CreateSchemaListener($this));
        $evm->addEventSubscriber(new LogRevisionsListener($this));
    }
}
