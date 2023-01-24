<?php

namespace App\ResponseDTO;

use Exception;

final class CompanyResponseDTO extends AbstractResponseDTO
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

    public function create(array $apiData): self
    {
        $this->name = $apiData['companyName'];
        $this->imageUrl = $apiData['image'];

        return $this->hydrateDTO($this, $apiData);
    }

    /**
     * @throws Exception
     */
    public function setIpoDate(string $ipoDate): self
    {
        $this->ipoDate = new \DateTimeImmutable($ipoDate);
        return $this;
    }
}