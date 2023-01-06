<?php

namespace App\EventSubscriber;

use App\Event\IndexListUpdatedEvent;
use App\Event\ProfileUpdatedEvent;
use App\Event\QuoteUpdatedEvent;
use App\Message\ProfileRequest;
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
            IndexListUpdatedEvent::class => [
                ['onIndexListUpdated']
            ],
            ProfileUpdatedEvent::class => [
                ['updateQuote'],
                ['uploadAvatar']
            ],
            /* QuoteUpdatedEvent::class => [],*/
        ];
    }

    public function onIndexListUpdated(IndexListUpdatedEvent $event)
    {
        foreach ($event->getIndexList()->symbols as $symbol) {
            $this->messageBus->dispatch(new ProfileRequest($symbol));
        }
    }

    public function updateQuote(ProfileUpdatedEvent $event)
    {
        $this->messageBus->dispatch(new QuoteRequest($event->getCompanyId()));
    }

    public function uploadAvatar(ProfileUpdatedEvent $event)
    {
    }
}