<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Invoice\InvoiceAction as InvoiceActionEnum;

class InvoiceAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'action',
        'description',
    ];

    protected $casts = [
        'action' => InvoiceActionEnum::class,
    ];
}
