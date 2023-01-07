<?php

namespace App\Message;

final class CompanyRequest
{
    private string $symbol;

    public function __construct(string $symbol)
  {
      $this->symbol = $symbol;
  }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
