<?php

namespace App\Entity;

use App\Repository\PerformanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerformanceRepository::class)]
class Performance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'day1', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $day1 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $day5 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $month1 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $month3 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $month6 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $yearToDay = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $year1 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $year3 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $year5 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $year10 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $max = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDay1(): ?string
    {
        return $this->day1;
    }

    public function setDay1(string $day1): self
    {
        $this->day1 = $day1;

        return $this;
    }

    public function getDay5(): ?string
    {
        return $this->day5;
    }

    public function setDay5(string $day5): self
    {
        $this->day5 = $day5;

        return $this;
    }

    public function getMonth1(): ?string
    {
        return $this->month1;
    }

    public function setMonth1(string $month1): self
    {
        $this->month1 = $month1;

        return $this;
    }

    public function getMonth3(): ?string
    {
        return $this->month3;
    }

    public function setMonth3(string $month3): self
    {
        $this->month3 = $month3;

        return $this;
    }

    public function getMonth6(): ?string
    {
        return $this->month6;
    }

    public function setMonth6(string $month6): self
    {
        $this->month6 = $month6;

        return $this;
    }

    public function getYearToDay(): ?string
    {
        return $this->yearToDay;
    }

    public function setYearToDay(string $yearToDay): self
    {
        $this->yearToDay = $yearToDay;

        return $this;
    }

    public function getYear1(): ?string
    {
        return $this->year1;
    }

    public function setYear1(string $year1): self
    {
        $this->year1 = $year1;

        return $this;
    }

    public function getYear3(): ?string
    {
        return $this->year3;
    }

    public function setYear3(string $year3): self
    {
        $this->year3 = $year3;

        return $this;
    }

    public function getYear5(): ?string
    {
        return $this->year5;
    }

    public function setYear5(string $year5): self
    {
        $this->year5 = $year5;

        return $this;
    }

    public function getYear10(): ?string
    {
        return $this->year10;
    }

    public function setYear10(string $year10): self
    {
        $this->year10 = $year10;

        return $this;
    }

    public function getMax(): ?string
    {
        return $this->max;
    }

    public function setMax(string $max): self
    {
        $this->max = $max;

        return $this;
    }
}
