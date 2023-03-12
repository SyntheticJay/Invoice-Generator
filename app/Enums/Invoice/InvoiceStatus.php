<?php declare(strict_types=1);

namespace App\Enums\Invoice;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

final class InvoiceStatus extends Enum
{
    #[Description('Awaiting')]
    const AWAITING = 1;

    #[Description('Paid')]
    const PAID = 3;
}