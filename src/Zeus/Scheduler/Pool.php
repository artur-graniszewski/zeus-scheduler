<?php

namespace Zeus\Scheduler;

use Zeus\Scheduler\Discipline\DisciplineInterface;

class Pool implements PoolInterface
{
    /** @var DisciplineInterface */
    private $discipline;

    /** @var string */
    private $name;

    public function getDiscipline() : DisciplineInterface
    {
        return $this->discipline;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function __construct(string $name, DisciplineInterface $discipline)
    {
        $this->discipline = $discipline;
        $this->name = $name;
    }
}