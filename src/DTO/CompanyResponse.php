<?php

namespace App\DTO;

use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

final class CompanyResponse extends AbstractResponse
{
    public string $symbol;
    //$response['companyName']
    public string $name;
    public float $beta;
    public float $lastDiv;
    public string $cik;
    public string $website;
    public string $description;
    public string $ceo;
    public string $country;
    public int $fullTimeEmployees;
    public ?string $phone;
    public string $address;
    public string $city;
    public ?string $state;
    public ?string $zip;
    public ?float $dcfDiff;
    public ?float $dcf;
    public string $imageUrl;
    public \DateTimeImmutable $ipoDate;
    public string $sector; //Sector->name
    public string $industry; //Industry->name

    /**
     * @throws ExceptionInterface
     */
    public static function create(array $response): self
    {
        $response['name'] = $response['companyName'];
        $response['imageUrl'] = $response['image'];
        unset($response['companyName'], $response['image']);

        return parent::denormalize($response);
    }

    /**
     * @throws Exception
     */
    public function setIpoDate(string $ipoDate): CompanyResponse
    {
        $this->ipoDate = new \DateTimeImmutable($ipoDate);
        return $this;
    }
}