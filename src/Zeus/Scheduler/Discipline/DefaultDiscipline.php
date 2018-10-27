<?php

namespace Zeus\Scheduler\Discipline;

use Zeus\Scheduler\Executor;

class DefaultDiscipline implements DisciplineInterface
{
    /** @var Executor[] */
    private $executors = [];

    public function __construct()
    {

    }
}