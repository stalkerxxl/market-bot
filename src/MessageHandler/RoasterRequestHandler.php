<?php

namespace App\MessageHandler;

use App\ResponseDTO\QuoteResponse;
use App\ResponseDTO\RoasterResponse;
use App\Entity\Company;
use App\Entity\Roaster;
use App\Message\RoasterRequest;
use App\Repository\RoasterRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler]
final class RoasterRequestHandler extends AbstractRequestHandler
{
    /**
     * @throws \Exception
     * @throws ExceptionInterface
     */
    public function __invoke(RoasterRequest $message)
    {
        try {
            $company = $this->entityManager->getRepository(Company::class)
                ->find($message->getCompanyId());
            $response = $this->client->getInsiderRoasterStatistic($company->getSymbol());

            $roasterRepo = $this->entityManager->getRepository(Roaster::class);
            foreach ($response as $item) {
                $dto = RoasterResponse::create($item);
                $roaster = $this->findOrCreateRoaster($dto, $company, $roasterRepo);
                $this->hydrateEntityFromDTO($roaster, $dto);
                $this->validateEntity($roaster);
            }
            $this->entityManager->flush();

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws ExceptionInterface
     */
    private function findOrCreateRoaster(RoasterResponse $dto, Company $company, RoasterRepository $roasterRepo): Roaster
    {
        $roaster = $roasterRepo->findOneBy([
            'company' => $company,
            'year' => $dto->year,
            'quarter' => $dto->quarter
        ]);

        if (null == $roaster) {
            $roaster = new Roaster();
            $roaster->setCompany($company);
            $this->entityManager->persist($roaster);
        }

        return $roaster;
    }
}
