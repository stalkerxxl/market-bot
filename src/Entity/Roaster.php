<?php

namespace App\Entity;

use App\Repository\RoasterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RoasterRepository::class)]
#[UniqueEntity(fields: ['company', 'year', 'quarter'])]
class Roaster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $year = null;

    #[ORM\Column]
    private ?int $quarter = null;

    #[ORM\Column]
    private ?int $purchases = null;

    #[ORM\Column]
    private ?int $sales = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $buySellRatio = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $totalBought = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $totalSold = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $averageBought = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $averageSold = null;

    #[ORM\Column]
    private ?int $pPurchases = null;

    #[ORM\Column]
    private ?int $sSales = null;

    #[ORM\ManyToOne(inversedBy: 'roasters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?\DateTimeImmutable
    {
        return $this->year;
    }

    public function setYear(\DateTimeImmutable $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    public function setQuarter(int $quarter): self
    {
        $this->quarter = $quarter;

        return $this;
    }

    public function getPurchases(): ?int
    {
        return $this->purchases;
    }

    public function setPurchases(int $purchases): self
    {
        $this->purchases = $purchases;

        return $this;
    }

    public function getSales(): ?int
    {
        return $this->sales;
    }

    public function setSales(int $sales): self
    {
        $this->sales = $sales;

        return $this;
    }

    public function getBuySellRatio(): ?string
    {
        return $this->buySellRatio;
    }

    public function setBuySellRatio(string $buySellRatio): self
    {
        $this->buySellRatio = $buySellRatio;

        return $this;
    }

    public function getTotalBought(): ?string
    {
        return $this->totalBought;
    }

    public function setTotalBought(string $totalBought): self
    {
        $this->totalBought = $totalBought;

        return $this;
    }

    public function getTotalSold(): ?string
    {
        return $this->totalSold;
    }

    public function setTotalSold(string $totalSold): self
    {
        $this->totalSold = $totalSold;

        return $this;
    }

    public function getAverageBought(): ?string
    {
        return $this->averageBought;
    }

    public function setAverageBought(string $averageBought): self
    {
        $this->averageBought = $averageBought;

        return $this;
    }

    public function getAverageSold(): ?string
    {
        return $this->averageSold;
    }

    public function setAverageSold(string $averageSold): self
    {
        $this->averageSold = $averageSold;

        return $this;
    }

    public function getPPurchases(): ?int
    {
        return $this->pPurchases;
    }

    public function setPPurchases(int $pPurchases): self
    {
        $this->pPurchases = $pPurchases;

        return $this;
    }

    public function getSSales(): ?int
    {
        return $this->sSales;
    }

    public function setSSales(int $sSales): self
    {
        $this->sSales = $sSales;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
