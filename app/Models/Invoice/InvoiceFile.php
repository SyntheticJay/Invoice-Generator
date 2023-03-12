<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'file_name',
        'file_size'
    ];
}
