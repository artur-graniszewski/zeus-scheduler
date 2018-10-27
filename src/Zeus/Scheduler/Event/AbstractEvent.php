<?php

namespace Zeus\Scheduler\Event;

use Zend\EventManager\Event;
use Zeus\Scheduler\Executor;

abstract class AbstractEvent extends Event
{
    public function __construct(Executor $executor)
    {
        parent::__construct(static::class, $executor);
    }

    public function getTarget() : Executor
    {
        return parent::getTarget();
    }
}