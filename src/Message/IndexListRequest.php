<?php

namespace App\Message;

use App\Enum\IndexList;

final class IndexListRequest
{
    private ?IndexList $index;

    public function __construct(?IndexList $index)
   {
       $this->index = $index;
   }

    public function getIndex(): ?IndexList
    {
        return $this->index;
    }
}
