<?php

namespace App\Factory;

use App\ResponseDTO\ResponseDTOInterface;

class ResponseDTOFactory
{
    public function fromArray(ResponseDTOInterface $responseDTOClass, array $apiData): ResponseDTOInterface
    {
        return $responseDTOClass->create($apiData);
    }
}