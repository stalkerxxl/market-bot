<?php

namespace App\EventSubscriber;

use App\Event\IndexListUpdatedEvent;
use App\Event\CompanyUpdatedEvent;
use App\Event\QuoteUpdatedEvent;
use App\Message\CompanyRequest;
use App\Message\QuoteRequest;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CompanyUpdatedEvent::class => [
                ['updateQuote'],
                ['uploadAvatar']
            ],
            IndexListUpdatedEvent::class => [
                ['onIndexListUpdated']
            ],
            /* QuoteUpdatedEvent::class => [],*/
        ];
    }

    public function onIndexListUpdated(IndexListUpdatedEvent $event)
    {
        foreach ($event->getIndexList()->symbols as $symbol) {
            $this->messageBus->dispatch(new CompanyRequest($symbol));
        }
    }

    public function updateQuote(CompanyUpdatedEvent $event)
    {
        $this->messageBus->dispatch(new QuoteRequest($event->getCompanyId()));
    }

    public function uploadAvatar(CompanyUpdatedEvent $event)
    {
    }
}