<?php

namespace Zeus\Scheduler;

use function array_key_exists;

use InvalidArgumentException;
use Zeus\Scheduler\Event\CreatePool;
use Zeus\Scheduler\Event\RemovePool;
use Zeus\Scheduler\Event\SchedulerLoop;
use Zeus\Scheduler\Event\StartExecutor;
use Zeus\Scheduler\Event\StartScheduler;
use Zeus\Scheduler\Event\StopScheduler;

class Scheduler extends AbstractEventHandler
{
    /** @var PoolInterface[] */
    private $pools = [];

    /** @var bool */
    private $loopIsFinished = false;

    public function start()
    {
        $this->raise(new StartScheduler($this));
        sleep(3);
        $this->raise(new StartExecutor(new Executor(1)));
        $this->raise(new StartExecutor(new Executor(2)));
        $event = new SchedulerLoop($this);
        while (!$this->loopIsFinished()) {
            $this->raise($event);
        }

        $this->raise(new StopScheduler($this));
    }

    public function createPool(PoolInterface $pool)
    {
        if (array_key_exists($pool->getName(), $this->pools)) {
            throw new InvalidArgumentException("Pool already created: " . $pool->getName());
        }
        $this->raise(new CreatePool($pool));
        $this->pools[$pool->getName()] = $pool;
    }

    public function removePool(PoolInterface $pool)
    {
        if (!array_key_exists($pool->getName(), $this->pools)) {
            throw new InvalidArgumentException("Unknown pool: " . $pool->getName());
        }

        $this->raise(new RemovePool($pool));
        unset ($this->pools[$pool->getName()]);
    }

    public function finishLoop(bool $finish)
    {
        $this->loopIsFinished = $finish;
    }

    public function loopIsFinished() : bool
    {
        return $this->loopIsFinished;
    }
}