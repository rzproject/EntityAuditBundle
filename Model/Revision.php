<?php

namespace Rz\EntityAuditBundle\Model;

use SimpleThings\EntityAudit\Revision as BaseRevision;

/**
 * Revision is returned from {@link AuditReader::getRevisions()}
 */
class Revision extends BaseRevision
{
    protected $rev;
    protected $timestamp;
    protected $username;

    function __construct($rev, $timestamp, $username)
    {
        $this->rev = $rev;
        $this->timestamp = $timestamp;
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getRev()
    {
        return $this->rev;
    }

    /**
     * @param mixed $rev
     */
    public function setRev($rev)
    {
        $this->rev = $rev;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


}