<?php

namespace Rz\EntityAuditBundle\Model;

use SimpleThings\EntityAudit\ChangedEntity as BaseChangedEntity;

class ChangedEntity extends BaseChangedEntity
{
    protected $className;
    protected $id;
    protected $revType;
    protected $entity;

    public function __construct($className, array $id, $revType, $entity)
    {
        $this->className = $className;
        $this->id = $id;
        $this->revType = $revType;
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return array
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRevType()
    {
        return $this->revType;
    }

    /**
     * @param mixed $revType
     */
    public function setRevType($revType)
    {
        $this->revType = $revType;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
