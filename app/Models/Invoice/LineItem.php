<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\VATRule\VATRule;

class LineItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'vat_id',
        'quantity',
        'unit_price',
        'vat_value',
        'total'
    ];

    protected $casts = [
        'quantity'    => 'integer'
    ];

    /**
     * Get the formatted unit price
     *
     * @return string
     */
    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 2);
    }

    /**
     * Get the formatted VAT value
     *
     * @return string
     */
    public function getFormattedVATValueAttribute()
    {
        return number_format($this->vat_value, 2);
    }

    /**
     * Get the formatted total
     *
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    /**
     * Get the VAT Rule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vatRule()
    {
        return $this->belongsTo(VATRule::class, 'vat_id');
    }
}
