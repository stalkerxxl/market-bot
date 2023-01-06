<?php

namespace App\DTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

class IndexListResponse extends AbstractResponse
{
    public array $symbols;

    /**
     * @throws ExceptionInterface
     */
    public static function create(array $response): IndexListResponse
    {
        $data['symbols'] = array_column($response, 'symbol');
        return parent::denormalize($data);
    }
}