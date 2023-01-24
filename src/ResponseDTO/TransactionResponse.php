<?php

namespace App\ResponseDTO;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

class TransactionResponse
{
    public \DateTimeImmutable $filingDate;
    public \DateTimeImmutable $date;
    public string $cik;
    public string $type;
    public string $owned;
    public string $acquistionOrDisposition;
    public int $formType;
    public string $quantity;
    public string $price;
    public string $name;
    public string $link;
    public string $insiderName; //Insider->name
    public string $insiderPosition; //Insider->position

    /**
     * @throws ExceptionInterface
     */
    public static function create(array $response): TransactionResponse
    {// FIXME херня какая-то.. переделать всю логику Response
        $response['filingDate'] = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $response['filingDate']);
        $response['date'] = \DateTimeImmutable::createFromFormat('Y-m-d', $response['transactionDate']);
        $response['cik'] = $response['reportingCik'];
        $response['type'] = $response['transactionType'];
        $response['owned'] = $response['securitiesOwned'];
        $response['quantity'] = $response['securitiesTransacted'];
        $response['name'] = $response['securityName'];
        $response['insiderName'] = $response['reportingName'];
        $response['insiderPosition'] = $response['typeOfOwner'];

        unset(
            $response['transactionDate'],
            $response['reportingCik'],
            $response['transactionType'],
            $response['securitiesOwned'],
            $response['securitiesTransacted'],
            $response['securityName'],
            $response['reportingName'],
            $response['typeOfOwner']
        );

        //return parent::denormalize($response);
    }
}