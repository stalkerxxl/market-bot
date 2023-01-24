<?php

namespace App\MessageHandler;

use App\ResponseDTO\QuoteResponse;
use App\Entity\Company;
use App\Entity\Quote;
use App\Event\QuoteUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\QuoteRequest;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler]
final class QuoteRequestHandler extends AbstractRequestHandler
{
    /**
     * @throws ExceptionInterface
     * @throws FmpClientException
     */
    public function __invoke(QuoteRequest $message): void
    {
        try {
            $company = $this->entityManager->getRepository(Company::class)
                ->find($message->getCompanyId());

            $response = $this->client->getQuote($company->getSymbol());
            $dto = QuoteResponse::create($response[0]);

            // FIXME проверять Entity, а не Response
            $this->validateEntity($dto);

            $quote = $company->getQuote();
            if (null == $quote) {
                $quote = new Quote();
                $quote->setCompany($company);
                $this->entityManager->persist($quote);
            }
            $this->hydrateEntityFromDTO($quote, $dto);

            $this->entityManager->flush();
            $this->eventDispatcher->dispatch(new QuoteUpdatedEvent($company->getId()));

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }
}
