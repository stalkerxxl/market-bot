<?php

namespace App\Message;

final class PerformanceRequest
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
