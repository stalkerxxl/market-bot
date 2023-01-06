<?php

namespace App\DTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractResponse
{
    abstract public static function create(array $response);

    /**
     * @throws ExceptionInterface
     */
    protected static function denormalize(array $response): static
    {
        return (new ObjectNormalizer())
            ->denormalize($response, static::class);
    }
}