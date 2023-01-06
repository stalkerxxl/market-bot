<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class PerformanceUpdatedEvent extends Event
{
    private int $companyId;

    public function __construct(int $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}