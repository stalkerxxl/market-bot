<?php

namespace App\DTO;

use Exception;
use Symfony\Component\Validator\Constraints as Assert;

final class ProfileResponse
{
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $symbol;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $companyName; //Company->name

    #[Assert\NotNull]
    #[Assert\Type(type: 'numeric')]
    public float $beta;

    #[Assert\NotNull]
    #[Assert\Type(type: 'numeric')]
    public float $lastDiv;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $cik;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $website;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $description;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $ceo;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $country;

    #[Assert\NotNull]
    #[Assert\Type(type: 'numeric')]
    public int $fullTimeEmployees;

    #[Assert\Type(type: 'string')]
    public ?string $phone;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $address;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $city;

    #[Assert\Type(type: 'string')]
    public ?string $state;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type(type: 'string')]
    public ?string $zip;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type(type: 'numeric')]
    public ?float $dcfDiff;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type(type: 'numeric')]
    public ?float $dcf;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $image; //Company->imageUrl

    #[Assert\NotBlank]
    //FIXME так и не понял, как проверить на "datetime"
    public \DateTimeImmutable $ipoDate;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $sector; //Sector->name

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    public string $industry; //Industry->name

    /**
     * @throws Exception
     */
    public function setIpoDate(string $ipoDate): ProfileResponse
    {
        $this->ipoDate = new \DateTimeImmutable($ipoDate);
        return $this;
    }
}