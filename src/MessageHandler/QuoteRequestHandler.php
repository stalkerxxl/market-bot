<?php

namespace App\MessageHandler;

use App\ApiClient\FmpClient;
use App\DTO\ProfileResponse;
use App\DTO\QuoteResponse;
use App\Entity\Company;
use App\Entity\Quote;
use App\Event\QuoteUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\QuoteRequest;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler]
final class QuoteRequestHandler
{
    private FmpClient $client;
    private LoggerInterface $logger;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        FmpClient                $client,
        LoggerInterface          $logger,
        EntityManagerInterface   $entityManager,
        ValidatorInterface       $validator,
        EventDispatcherInterface $eventDispatcher)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @throws ExceptionInterface
     * @throws FmpClientException
     */
    public function __invoke(QuoteRequest $message): void
    {
        try {
            $response = $this->client->getQuote($message->getSymbol());
            $dto = (new ObjectNormalizer())
                ->denormalize($response[0], QuoteResponse::class);

            $errors = $this->validator->validate($dto);
            if ($errors->count() > 0) {
                $this->logger->alert('validation error', [$dto->symbol]);
                throw new ValidatorException($dto->symbol . ': ' . (string)$errors);
            }

            $company = $this->entityManager->getRepository(Company::class)
                ->findOneBy(['symbol' => $message->getSymbol()]);
            $quote = $company->getQuote();
            if (null == $quote) {
                $quote = new Quote();
                $quote->setCompany($company);
                $this->entityManager->persist($quote);
            }

            /** @var QuoteResponse $dto */
            $quote->setPrice($dto->price)
                ->setOpen($dto->open)
                ->setPreviousClose($dto->previousClose)
                ->setChange($dto->change)
                ->setChangesPercentage($dto->changesPercentage)
                ->setDayLow($dto->dayLow)
                ->setDayHigh($dto->dayHigh)
                ->setYearLow($dto->yearLow)
                ->setYearHigh($dto->yearHigh)
                ->setMarketCap($dto->marketCap)
                ->setPriceAvg50($dto->priceAvg50)
                ->setPriceAvg200($dto->priceAvg200)
                ->setVolume($dto->volume)
                ->setAvgVolume($dto->avgVolume)
                ->setEps($dto->eps)
                ->setPe($dto->pe)
                ->setEarningsAnnouncement($dto->earningsAnnouncement)
                ->setSharesOutstanding($dto->sharesOutstanding)
                ->setApiTimestamp($dto->timestamp);

            $this->entityManager->flush();
            $this->eventDispatcher->dispatch(new QuoteUpdatedEvent($company));

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }
}
