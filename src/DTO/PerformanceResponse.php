<?php

namespace App\DTO;

class PerformanceResponse extends AbstractResponse
{
    public float $day1;
    public float $day5;
    public float $month1;
    public float $month3;
    public float $month6;
    public float $yearToDay;
    public float $year1;
    public float $year3;
    public float $year5;
    public float $year10;
    public float $max;

    public static function create(array $response): PerformanceResponse
    {
        $dto = new self();
        $dto->day1 = $response['1D'];
        $dto->day5 = $response['5D'];
        $dto->month1 = $response['1M'];
        $dto->month3 = $response['3M'];
        $dto->month6 = $response['6M'];
        $dto->yearToDay = $response['ytd'];
        $dto->year1 = $response['1Y'];
        $dto->year3 = $response['3Y'];
        $dto->year5 = $response['5Y'];
        $dto->year10 = $response['10Y'];
        $dto->max = $response['max'];

        return $dto;
    }
}