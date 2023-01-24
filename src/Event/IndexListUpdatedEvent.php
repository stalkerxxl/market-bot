<?php

namespace App\Event;

use App\ResponseDTO\IndexListResponse;
use Symfony\Contracts\EventDispatcher\Event;

class IndexListUpdatedEvent extends Event
{
    private IndexListResponse $indexList;

    public function __construct(IndexListResponse $indexList)
    {
        $this->indexList = $indexList;
    }

    public function getIndexList(): IndexListResponse
    {
        return $this->indexList;
    }

}