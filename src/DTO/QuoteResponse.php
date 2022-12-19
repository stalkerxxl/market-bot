<?php

namespace App\DTO;

use DateTimeImmutable;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

class QuoteResponse
{
    #[Assert\NotBlank]
    public string $symbol;

    #[Assert\Type('numeric')]
    public float $price;

    #[Assert\Type('numeric')]
    public float $open;

    #[Assert\Type('numeric')]
    public float $previousClose;

    #[Assert\Type('numeric')]
    public float $change;

    #[Assert\Type('numeric')]
    public float $changesPercentage;

    #[Assert\Type('numeric')]
    public float $dayLow;

    #[Assert\Type('numeric')]
    public float $dayHigh;

    #[Assert\Type('numeric')]
    public float $yearLow;

    #[Assert\Type('numeric')]
    public float $yearHigh;

    #[Assert\Type('numeric')]
    public int $marketCap;

    #[Assert\Type('numeric')]
    public float $priceAvg50;

    #[Assert\Type('numeric')]
    public float $priceAvg200;

    #[Assert\Type('numeric')]
    public int $volume;

    #[Assert\Type('numeric')]
    public int $avgVolume;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type('numeric')]
    public ?float $eps;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type('numeric')]
    public ?float $pe;

    #[Assert\Type('object')]
    //FIXME как сделать проверку на DateTime?
    public ?\DateTimeImmutable $earningsAnnouncement;

    #[Assert\Type('numeric')]
    public int $sharesOutstanding;

    #[Assert\Type('object')]
    //FIXME как сделать проверку на DateTime?
    public \DateTimeImmutable $timestamp; //Quote->apiTimestamp


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

    public function setTimestamp(int $timestamp): QuoteResponse
    {
        $this->timestamp = DateTimeImmutable::createFromFormat('U',$timestamp);
        return $this;
    }
}