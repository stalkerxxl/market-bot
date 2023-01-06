<?php

namespace App\MessageHandler;

use App\DTO\PerformanceResponse;
use App\Entity\Company;
use App\Entity\Performance;
use App\Event\PerformanceUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\PerformanceRequest;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PerformanceRequestHandler extends AbstractRequestHandler
{
    /**
     * @throws FmpClientException
     */
    public function __invoke(PerformanceRequest $message)
    {
        try {
            $companyRepository = $this->entityManager->getRepository(Company::class);
            $company = $companyRepository->find($message->getCompanyId());

            $response = $this->client->getStockPriceChange($company->getSymbol());
            $dto = PerformanceResponse::create($response[0]);

            //FIXME валидировать Entity, а не DTO
            $this->validateEntity($dto);

            $performance = $company->getPerformance();
            if (null == $performance) {
                $performance = new Performance();
                $performance->setCompany($company);
                $this->entityManager->persist($performance);
            }
            $this->hydrateEntityFromDTO($performance, $dto);

            $this->entityManager->flush();
            $this->eventDispatcher->dispatch(new PerformanceUpdatedEvent($company->getId()));

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }
}
