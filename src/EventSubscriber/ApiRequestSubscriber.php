<?php

namespace App\EventSubscriber;

use App\Entity\Company;
use App\Event\IndexListUpdatedEvent;
use App\Event\CompanyUpdatedEvent;
use App\Event\QuoteUpdatedEvent;
use App\Message\CompanyRequest;
use App\Message\DownloadCompanyLogo;
use App\Message\PerformanceRequest;
use App\Message\QuoteRequest;
use App\Message\RoasterRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;
    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $messageBus, EntityManagerInterface $entityManager)
    {
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CompanyUpdatedEvent::class => [
                ['onCompanyUpdated']
            ],
            IndexListUpdatedEvent::class => [
                ['onIndexListUpdated']
            ],
            /* QuoteUpdatedEvent::class => [],*/
        ];
    }

    public function onCompanyUpdated(CompanyUpdatedEvent $event)
    {
        $company = $this->entityManager->getRepository(Company::class)->find($event->getCompanyId());

        if (is_null($company->getAvatar()))
            $this->messageBus->dispatch(new DownloadCompanyLogo($company->getId()));

        if (is_null($company->getQuote()))
            $this->messageBus->dispatch(new QuoteRequest($company->getId()));

        if ($company->getRoasters()->count() == 0)
            $this->messageBus->dispatch(new RoasterRequest($company->getId()));

        if (is_null($company->getPerformance()))
            $this->messageBus->dispatch(new PerformanceRequest($company->getId()));
    }

    public function onIndexListUpdated(IndexListUpdatedEvent $event)
    {
        $companyInDB = $this->entityManager->getRepository(Company::class)->findAll();
        $symbols = array_map(function ($item) {
            return $item->getSymbol();
        }, $companyInDB);
        $fullUniqueList = array_unique(array_merge($symbols, $event->getIndexList()->symbols));

        foreach ($fullUniqueList as $symbol) {
            $this->messageBus->dispatch(new CompanyRequest($symbol));
        }
    }
}