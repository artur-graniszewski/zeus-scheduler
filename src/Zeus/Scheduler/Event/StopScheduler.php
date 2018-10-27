<?php

namespace Zeus\Scheduler\Event;

use Zend\EventManager\Event;
use Zeus\Scheduler\Scheduler;

class StopScheduler extends Event
{
    public function __construct(Scheduler $scheduler)
    {
        parent::__construct(static::class, $scheduler);
    }

    public function getTarget() : Scheduler
    {
        return parent::getTarget();
    }
}