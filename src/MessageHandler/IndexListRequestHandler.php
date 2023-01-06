<?php

namespace App\MessageHandler;

use App\DTO\IndexListResponse;
use App\Event\IndexListUpdatedEvent;
use App\Exception\FmpClientException;
use App\Message\IndexListRequest;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler]
final class IndexListRequestHandler extends AbstractRequestHandler
{
    /**
     * @throws FmpClientException|ExceptionInterface
     */
    public function __invoke(IndexListRequest $message)
    {
        try {
            $response = $this->client->getIndexList($message->getIndex());
            //FIXME валидация?
            $dto = IndexListResponse::create($response);

            $this->eventDispatcher->dispatch(new IndexListUpdatedEvent($dto));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }
}
