<?php

namespace App\Models\VATRule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VATRule extends Model
{
    use HasFactory;

    protected $table    = 'vatrules';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'percentage',
        'vat_code',
        'nominal_vat',
        'is_archived'
    ];

    protected $casts = [
        'is_archived' => 'boolean'
    ];
}
