<?php declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry;

use QuetzalStudio\PhpSnapBi\Concerns\HasService;
use QuetzalStudio\PhpSnapBi\Contracts\Service;
use QuetzalStudio\PhpSnapBi\Services\Service as BaseService;

class AccountInquiry extends BaseService implements Service
{
    use HasService;

    protected string $version = 'v1.0';

    protected string $endpoint = '/:version/emoney/bank-account-inquiry.htm';
}
