<?php

namespace Zeus\Scheduler\Event;

use Zend\EventManager\Event;
use Zeus\Scheduler\PoolInterface;

class RemovePool extends Event
{
    public function __construct(PoolInterface $pool)
    {
        parent::__construct(static::class, $pool);
    }

    public function getTarget() : PoolInterface
    {
        return parent::getTarget();
    }
}