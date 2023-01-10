<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[UniqueEntity(['company', 'type', 'owned', 'quantity', 'insider', 'date', 'filingDate'])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $filingDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $cik = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $owned = null;

    #[ORM\Column(length: 10)]
    private ?string $acquistionOrDisposition = null;

    #[ORM\Column]
    private ?int $formType = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Insider $Insider = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilingDate(): ?\DateTimeImmutable
    {
        return $this->filingDate;
    }

    public function setFilingDate(\DateTimeImmutable $filingDate): self
    {
        $this->filingDate = $filingDate;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCik(): ?string
    {
        return $this->cik;
    }

    public function setCik(string $cik): self
    {
        $this->cik = $cik;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOwned(): ?string
    {
        return $this->owned;
    }

    public function setOwned(string $owned): self
    {
        $this->owned = $owned;

        return $this;
    }

    public function getAcquistionOrDisposition(): ?string
    {
        return $this->acquistionOrDisposition;
    }

    public function setAcquistionOrDisposition(string $acquistionOrDisposition): self
    {
        $this->acquistionOrDisposition = $acquistionOrDisposition;

        return $this;
    }

    public function getFormType(): ?int
    {
        return $this->formType;
    }

    public function setFormType(int $formType): self
    {
        $this->formType = $formType;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getInsider(): ?Insider
    {
        return $this->Insider;
    }

    public function setInsider(?Insider $Insider): self
    {
        $this->Insider = $Insider;

        return $this;
    }
}
