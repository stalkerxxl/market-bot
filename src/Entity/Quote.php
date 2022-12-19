<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
#[UniqueEntity('company')]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $open = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $previousClose = null;

    #[ORM\Column(name: 'change_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $change = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $changesPercentage = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $dayLow = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $dayHigh = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $yearLow = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $yearHigh = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $marketCap = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceAvg50 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceAvg200 = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $volume = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $avgVolume = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $eps = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $pe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $earningsAnnouncement = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $sharesOutstanding = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $apiTimestamp = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(inversedBy: 'quote', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOpen(): ?string
    {
        return $this->open;
    }

    public function setOpen(string $open): self
    {
        $this->open = $open;

        return $this;
    }

    public function getPreviousClose(): ?string
    {
        return $this->previousClose;
    }

    public function setPreviousClose(string $previousClose): self
    {
        $this->previousClose = $previousClose;

        return $this;
    }

    public function getChange(): ?string
    {
        return $this->change;
    }

    public function setChange(string $change): self
    {
        $this->change = $change;

        return $this;
    }

    public function getDayLow(): ?string
    {
        return $this->dayLow;
    }

    public function setDayLow(string $dayLow): self
    {
        $this->dayLow = $dayLow;

        return $this;
    }

    public function getDayHigh(): ?string
    {
        return $this->dayHigh;
    }

    public function setDayHigh(string $dayHigh): self
    {
        $this->dayHigh = $dayHigh;

        return $this;
    }

    public function getYearLow(): ?string
    {
        return $this->yearLow;
    }

    public function setYearLow(string $yearLow): self
    {
        $this->yearLow = $yearLow;

        return $this;
    }

    public function getYearHigh(): ?string
    {
        return $this->yearHigh;
    }

    public function setYearHigh(string $yearHigh): self
    {
        $this->yearHigh = $yearHigh;

        return $this;
    }

    public function getMarketCap(): ?string
    {
        return $this->marketCap;
    }

    public function setMarketCap(string $marketCap): self
    {
        $this->marketCap = $marketCap;

        return $this;
    }

    public function getPriceAvg50(): ?string
    {
        return $this->priceAvg50;
    }

    public function setPriceAvg50(string $priceAvg50): self
    {
        $this->priceAvg50 = $priceAvg50;

        return $this;
    }

    public function getPriceAvg200(): ?string
    {
        return $this->priceAvg200;
    }

    public function setPriceAvg200(string $priceAvg200): self
    {
        $this->priceAvg200 = $priceAvg200;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getAvgVolume(): ?string
    {
        return $this->avgVolume;
    }

    public function setAvgVolume(string $avgVolume): self
    {
        $this->avgVolume = $avgVolume;

        return $this;
    }

    public function getEps(): ?string
    {
        return $this->eps;
    }

    public function setEps(?string $eps): self
    {
        $this->eps = $eps;

        return $this;
    }

    public function getPe(): ?string
    {
        return $this->pe;
    }

    public function setPe(?string $pe): self
    {
        $this->pe = $pe;

        return $this;
    }

    public function getEarningsAnnouncement(): ?\DateTimeImmutable
    {
        return $this->earningsAnnouncement;
    }

    public function setEarningsAnnouncement(?\DateTimeImmutable $earningsAnnouncement): self
    {
        $this->earningsAnnouncement = $earningsAnnouncement;

        return $this;
    }

    public function getSharesOutstanding(): ?string
    {
        return $this->sharesOutstanding;
    }

    public function setSharesOutstanding(string $sharesOutstanding): self
    {
        $this->sharesOutstanding = $sharesOutstanding;

        return $this;
    }

    public function getApiTimestamp(): ?\DateTimeImmutable
    {
        return $this->apiTimestamp;
    }

    public function setApiTimestamp(\DateTimeImmutable $apiTimestamp): self
    {
        $this->apiTimestamp = $apiTimestamp;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getChangesPercentage(): ?string
    {
        return $this->changesPercentage;
    }

    public function setChangesPercentage(string $changesPercentage): self
    {
        $this->changesPercentage = $changesPercentage;

        return $this;
    }
}
