<?php

namespace App\Enum;

enum TransactionTypes: string
{
    case Purchase = 'P-Purchase';
    case Sale = 'S-Sale';
    case Other = 'J-Other';
    case Will = 'W-Will';
    case Discretionary = 'I-Discretionary';
    case Trust = 'Z-Trust';
    case InKind = 'F-InKind';
    case ExpireShort = 'E-ExpireShort';
    case Conversion = 'C-Conversion';
    case OutOfTheMoney = 'O-OutOfTheMoney';
    case Small = 'L-Small';
    case Award = 'A-Award';
    case Exempt = 'M-Exempt';
    case Gift = 'G-Gift';
    case ExpireLong = 'H-ExpireLong';
    case InTheMoney = 'X-InTheMoney';
    case Return = 'D-Return';
    case Tender = 'U-Tender';

}
