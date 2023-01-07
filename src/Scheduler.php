<?php

namespace App;

use Psr\Log\LoggerInterface;
use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class Scheduler implements ScheduleBuilder
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function buildSchedule(Schedule $schedule): void
    {
       /* $schedule->addCallback(function () {
            return $this->logger->alert(__METHOD__);
        })->everyMinute();*/
    }
}