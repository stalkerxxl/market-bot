<?php

namespace App\ResponseDTO;

use DateTimeImmutable;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class QuoteResponse
{
    public float $price;
    public float $open;
    public float $previousClose;
    public float $change;
    public float $changesPercentage;
    public float $dayLow;
    public float $dayHigh;
    public float $yearLow;
    public float $yearHigh;
    public int $marketCap;
    public float $priceAvg50;
    public float $priceAvg200;
    public int $volume;
    public int $avgVolume;
    public ?float $eps;
    public ?float $pe;
    public ?\DateTimeImmutable $earningsAnnouncement;
    public int $sharesOutstanding;
    public \DateTimeImmutable $apiTimestamp;

    /**
     * @throws ExceptionInterface
     */
    public static function create(array $response): QuoteResponse
    {
        $response['apiTimestamp'] = $response['timestamp'];
        unset($response['timestamp']);

        //return parent::denormalize($response);
    }

    /**
     * @throws Exception
     */
    public function setEarningsAnnouncement(?string $datetime): void
    {
        if (null == $datetime) {
            $this->earningsAnnouncement = $datetime;
        } else {
            $this->earningsAnnouncement = new \DateTimeImmutable($datetime);
        }
    }

    public function setApiTimestamp(int $timestamp): QuoteResponse
    {
        $this->apiTimestamp = DateTimeImmutable::createFromFormat('U', $timestamp);
        return $this;
    }


}