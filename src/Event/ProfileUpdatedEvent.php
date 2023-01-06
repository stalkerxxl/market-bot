<?php

namespace App\Event;

use App\Entity\Company;
use Symfony\Contracts\EventDispatcher\Event;

class ProfileUpdatedEvent extends Event
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