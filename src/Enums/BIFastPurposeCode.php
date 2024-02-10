<?php

namespace QuetzalStudio\PhpSnapBi\Enums;

enum BIFastPurposeCode: string
{
    case INVESTMENT = '01';
    case TRANSFER_OF_WEALTH = '02';
    case PURCHASE = '03';
    case OTHER = '04';
}
