<?php

namespace App\ResponseDTO;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

abstract class AbstractResponseDTO implements ResponseDTOInterface
{
    abstract public function create(array $apiData): self;

    private function getPropertyAccessor(): PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            //->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor();
    }

    protected function hydrateDTO(self $dto, array $apiData): static
    {
        $propertyAccessor = $this->getPropertyAccessor();
        foreach ($apiData as $property => $value) {
            $propertyAccessor->setValue($dto, $property, $value);
        }
        return $dto;
    }
}