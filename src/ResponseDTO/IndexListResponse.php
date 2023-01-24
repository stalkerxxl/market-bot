<?php

namespace App\ResponseDTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

class IndexListResponse
{
    public array $symbols;

    /**
     * @throws ExceptionInterface
     */
  /*  public static function create(array $response): IndexListResponse
    {
        $data['symbols'] = array_unique(array_column($response, 'symbol'));
        return parent::denormalize($data);
    }*/
}