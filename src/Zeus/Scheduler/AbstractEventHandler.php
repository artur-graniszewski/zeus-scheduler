<?php

namespace Zeus\Scheduler;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

abstract class AbstractEventHandler
{
    /** @var EventManagerInterface */
    private $eventManager;

    public function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        $this->eventManager->attach('*', function(EventInterface $event) {
            $this->handle($event);
        });
    }

    protected function raise(EventInterface $event)
    {
        $this->eventManager->triggerEvent($event);
    }

    private function handle(EventInterface $event)
    {
        $name = explode('\\', $event->getName());

        $methodName = 'on' . array_pop($name);
        if (method_exists($this, $methodName)) {
            $this->$methodName($event->getTarget());
        }
    }
}