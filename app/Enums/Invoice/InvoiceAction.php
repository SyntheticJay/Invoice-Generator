<?php declare(strict_types=1);

namespace App\Enums\Invoice;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

final class InvoiceAction extends Enum
{
    #[Description('Generate Invoice')]
    const GENERATE_INVOICE = 1;

    #[Description('Send Invoice Email')]
    const SEND_INVOICE_EMAIL = 2;
}