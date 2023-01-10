<?php

namespace App\DTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractResponse
{
    abstract protected static function create(array $response);

    /**
     * @throws ExceptionInterface
     */
    protected static function denormalize(array $response): static
    {//FIXME переделать, чтоб принимал также частично заполненный объект DTO?
        return (new ObjectNormalizer())
            ->denormalize($response, static::class);
    }
}