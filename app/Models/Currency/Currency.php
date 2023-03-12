<?php

namespace App\Models\Currency;

use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'symbol',
        'exchange_rate',
        'is_archived'
    ];

    protected $casts = [
        'is_archived' => 'boolean'
    ];
}
