<?php

namespace App\MessageHandler;

use App\ResponseDTO\CompanyResponseDTO;
use App\Entity\Company;
use App\Entity\Industry;
use App\Entity\Sector;
use App\Event\CompanyUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\CompanyRequest;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler]
final class CompanyRequestHandler extends AbstractRequestHandler
{
    /**
     * @throws ExceptionInterface
     * @throws FmpClientException
     */
    public function __invoke(CompanyRequest $message): void
    {
        try {
            $response = $this->client->getProfile($message->getSymbol());
            $dto = $this->responseDTOFactory
                ->fromArray(new CompanyResponseDTO(), $response[0]);
            $this->validateEntity($dto);

            $sector = $this->makeSector($dto);
            $industry = $this->makeIndustry($dto, $sector);
            $company = $this->makeCompany($dto, $sector, $industry);

            $this->entityManager->flush();
            $this->eventDispatcher->dispatch(new CompanyUpdatedEvent($company->getId()));

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['symbol' => $message->getSymbol()]);
            throw $e;
        }
    }

    private function makeSector(CompanyResponseDTO $dto): Sector
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

    private function makeIndustry(CompanyResponseDTO $dto, Sector $sector): Industry
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

    private function makeCompany(CompanyResponseDTO $dto, Sector $sector, Industry $industry): Company
    {
        $companyRepository = $this->entityManager->getRepository(Company::class);
        $company = $companyRepository->findOneBy(['symbol' => $dto->symbol]);
        if ($company === null) {
            $company = new Company();
            $company->setSymbol($dto->symbol);
            $this->entityManager->persist($company);
        }
        unset($dto->industry, $dto->sector);
        $this->hydrateEntityFromDTO($company, $dto);
        $company->setSector($sector)
            ->setIndustry($industry);

        return $company;
    }
}
