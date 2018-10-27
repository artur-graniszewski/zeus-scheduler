<?php
namespace Zeus\Scheduler;

use Zeus\Scheduler\Discipline\DisciplineInterface;

interface PoolInterface
{
    public function getDiscipline() : DisciplineInterface;

    public function getName() : string;
}