<?php

namespace App\ResponseDTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

class RoasterResponse
{
    public int $year;
    public int $quarter;
    public int $purchases;
    public int $sales;
    public float $buySellRatio;
    public int $totalBought;
    public int $totalSold;
    public int $averageBought;
    public int $averageSold;
    public int $pPurchases;
    public int $sSales;

    /**
     * @throws ExceptionInterface
     */
    public static function create(array $response): RoasterResponse
    {
        //return parent::denormalize($response);
    }
}