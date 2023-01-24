<?php

namespace App\MessageHandler;

use App\ResponseDTO\IndexListResponse;
use App\Enum\IndexList;
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
            if ($message->getIndex()) {
                $response = $this->client->getIndexList($message->getIndex());
                $dto = IndexListResponse::create($response);
            } else {
                $fullList = [];
                foreach (IndexList::cases() as $index) {
                    $response = $this->client->getIndexList($index);
                    $fullList = array_merge($fullList, $response);
                }
                $dto = IndexListResponse::create($fullList);
            }
            //FIXME валидация?
            $this->eventDispatcher->dispatch(new IndexListUpdatedEvent($dto));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }
}
