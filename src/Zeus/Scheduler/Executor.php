<?php

namespace Zeus\Scheduler;

class Executor
{
    private $uid;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }
}