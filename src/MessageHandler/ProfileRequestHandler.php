<?php

namespace App\MessageHandler;

use App\ApiClient\FmpClient;
use App\DTO\ProfileResponse;
use App\Entity\Company;
use App\Entity\Industry;
use App\Entity\Sector;
use App\Event\ProfileUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\ProfileRequest;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final class ProfileRequestHandler
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
    public function __invoke(ProfileRequest $message): void
    {
        try {
            $response = $this->client->getProfile($message->getSymbol());
            $dto = (new ObjectNormalizer())
                ->denormalize($response[0], ProfileResponse::class);

            $errors = $this->validator->validate($dto);
            if ($errors->count() > 0) {
                $this->logger->alert('validation error', [$dto->symbol, $dto->companyName]);
                throw new ValidatorException($dto->symbol . ': ' . (string)$errors);
            }

            $sector = $this->makeSector($dto);
            $industry = $this->makeIndustry($dto, $sector);
            $company = $this->makeCompany($dto, $sector, $industry);

            $this->entityManager->flush();
            $this->eventDispatcher->dispatch(new ProfileUpdatedEvent($company));

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    private function makeSector(ProfileResponse $dto): Sector
    {
        $sectorRepository = $this->entityManager->getRepository(Sector::class);
        $sector = $sectorRepository->findOneBy(['name' => $dto->sector]);
        if ($sector === null) {
            $sector = new Sector();
            $sector->setName($dto->sector);
            $this->entityManager->persist($sector);
        }
        return $sector;
    }

    private function makeIndustry(ProfileResponse $dto, Sector $sector): Industry
    {
        $industryRepository = $this->entityManager->getRepository(Industry::class);
        $industry = $industryRepository->findOneBy(['name' => $dto->industry]);
        if ($industry === null) {
            $industry = new Industry();
            $industry->setName($dto->industry);
            $this->entityManager->persist($industry);
        }
        $industry->setSector($sector);

        return $industry;
    }

    private function makeCompany(ProfileResponse $dto, Sector $sector, Industry $industry): Company
    {
        $companyRepository = $this->entityManager->getRepository(Company::class);
        $company = $companyRepository->findOneBy(['symbol' => $dto->symbol]);
        if ($company === null) {
            $company = new Company();
            $company->setSymbol($dto->symbol);
            $this->entityManager->persist($company);
        }
        $company->setName($dto->companyName)
            ->setBeta($dto->beta)
            ->setLastDiv($dto->lastDiv)
            ->setCik($dto->cik)
            ->setWebsite($dto->website)
            ->setDescription($dto->description)
            ->setCeo($dto->ceo)
            ->setCountry($dto->country)
            ->setFullTimeEmployees($dto->fullTimeEmployees)
            ->setPhone($dto->phone)
            ->setAddress($dto->address)
            ->setCity($dto->city)
            ->setState($dto->state)
            ->setZip($dto->zip)
            ->setDcfDiff($dto->dcfDiff)
            ->setDcf($dto->dcf)
            ->setImageUrl($dto->image)
            ->setIpoDate($dto->ipoDate)
            ->setSector($sector)
            ->setIndustry($industry);

        return $company;
    }
}
