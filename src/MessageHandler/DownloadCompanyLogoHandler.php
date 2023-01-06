<?php

namespace App\MessageHandler;

use App\ApiClient\FmpClient;
use App\Entity\Company;
use App\Message\DownloadCompanyLogo;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;
#[AsMessageHandler]
final class DownloadCompanyLogoHandler extends AbstractRequestHandler
{
    public string $companyLogoDir;

    public function __construct(
        FmpClient                $client,
        LoggerInterface          $logger,
        EntityManagerInterface   $entityManager,
        ValidatorInterface       $validator,
        EventDispatcherInterface $eventDispatcher,
        string                   $companyLogoDir)
    {
        parent::__construct($client, $logger, $entityManager, $validator, $eventDispatcher);
        $this->companyLogoDir = $companyLogoDir;
    }

    /**
     * @throws Exception
     */
    public function __invoke(DownloadCompanyLogo $message)
    {//FIXME хардкод... переписать на UploadFile()
        $repo = $this->entityManager->getRepository(Company::class);
        $company = $repo->find($message->getCompanyId());

        $file = file_get_contents($company->getImageUrl());
        $result = file_put_contents($this->companyLogoDir . '/' . $company->getSymbol() . '.png', $file);
        if (!$result)
            throw new Exception('не удалось загрузить логотип ' . $company->getSymbol());

        $company->setAvatar($company->getSymbol() . '.svg');
        $this->entityManager->flush();
    }
}
