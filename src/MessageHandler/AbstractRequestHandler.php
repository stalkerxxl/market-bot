<?php

namespace App\MessageHandler;

use App\Factory\ResponseDTOFactory;
use App\Service\FmpApiService;
use App\ResponseDTO\AbstractResponseDTO;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequestHandler
{
    protected FmpApiService $client;
    protected LoggerInterface $logger;
    protected EntityManagerInterface $entityManager;
    protected ValidatorInterface $validator;
    protected EventDispatcherInterface $eventDispatcher;
    protected ResponseDTOFactory $responseDTOFactory;

    public function __construct(
        FmpApiService            $client,
        LoggerInterface          $logger,
        EntityManagerInterface   $entityManager,
        ValidatorInterface       $validator,
        EventDispatcherInterface $eventDispatcher,
        ResponseDTOFactory       $responseFactory)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->eventDispatcher = $eventDispatcher;
        $this->responseDTOFactory = $responseFactory;
    }

    protected function validateEntity(object $entity): void
    {
        $errors = $this->validator->validate($entity);
        if ($errors->count() > 0)
            throw new ValidatorException($errors->get(0)->getMessage());
    }

    protected function getPropertyAccessor(): PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            //->disableExceptionOnInvalidPropertyPath()
            //->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor();
    }

    protected function hydrateEntityFromDTO(object $entity, AbstractResponseDTO $dto): void
    {
        $propertyAccessor = $this->getPropertyAccessor();
        foreach ($dto as $property => $value) {
            $propertyAccessor->setValue($entity, $property, $value);
        }
    }
}