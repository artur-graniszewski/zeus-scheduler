<?php

include("vendor/autoload.php");

echo getmypid() . " > Starting...\n";
$ev = new \Zend\EventManager\EventManager();
$driver = new \Zeus\Multiprocessing\Driver\PosixProcess($ev);
$scheduler = new \Zeus\Scheduler\Scheduler($ev);
$scheduler->start();