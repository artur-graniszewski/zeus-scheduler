<?php

namespace Zeus\Multiprocessing\Driver;

use function pcntl_fork;
use function posix_getppid;
use function pcntl_wait;

use Zeus\Scheduler\Executor;
use Zeus\Scheduler\Scheduler;

class PosixProcess extends AbstractDriver
{
    private $clonePid = 0;
    private $schedulerPid = 0;

    public function onStartScheduler(Scheduler $scheduler)
    {
        // start idle executor
        $pid = pcntl_fork();
        if ($pid === -1) {
            throw new \RuntimeException("Could not fork new process");
        }

        if ($pid) {
            pcntl_sigprocmask(SIG_BLOCK, [SIGUSR2]);
            // we are the parent
            //pcntl_wait($status); //Protect against Zombie children
            $this->clonePid = $pid;
        } else {
            // we are the child
            if (!$this->schedulerPid) {
                $this->schedulerPid = posix_getppid();
            }

            echo getmypid() . " > I'm the clone\n";

            // wait for signals
            $info = [];
            pcntl_sigprocmask(SIG_BLOCK, [SIGUSR1, SIGINT, SIGCHLD]);
            do {
                pcntl_sigwaitinfo([SIGUSR1, SIGINT], $info);
                // clone the process
                if ($info['signo'] === SIGUSR1) {
                    echo getmypid() . " > Cloning...\n";
                    $this->startExecutor();
                } else if ($info['signo'] === SIGINT) {
                    echo getmypid() . " > Clone exiting...\n";
                    die();
                } else {
                    unset ($this->)
                }
            } while (true);
        }
    }

    public function onSchedulerStop(Scheduler $scheduler)
    {
        if ($this->clonePid) {
            pcntl_wait($status);
        }
    }

    public function onSchedulerLoop(Scheduler $scheduler)
    {
        if (0 < pcntl_sigtimedwait([SIGUSR2], $info, 1, 0)) {
            $pid = $info['pid'];
            echo getmypid() . " > Executor detected with PID: $pid\n";
        }
    }

    public function onStartExecutor(Executor $executor)
    {
        posix_kill($this->clonePid, SIGUSR1);
    }

    private function startExecutor()
    {
        // start idle executor
        $pid = pcntl_fork();
        if ($pid === -1) {
            throw new \RuntimeException("Could not fork new process");
        }

        if ($pid) {
            // we are the parent
            //pcntl_wait($status); //Protect against Zombie children
        } else {
            // we are the child
            echo getmypid() . " > Reporting to scheduler...\n";
            posix_kill($this->schedulerPid, SIGUSR2);
            pcntl_sigwaitinfo([SIGUSR1, SIGINT], $info);
        }
    }
}