<?php

namespace App\Models\Invoice;

use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Mail;

use App\Jobs\Invoice\GenerateInvoice;
use App\Jobs\Invoice\SendInvoiceEmail;

use App\Enums\Invoice\InvoiceStatus;

use App\Models\User;
use App\Models\Invoice\LineItem;
use App\Models\Currency\Currency;
use App\Models\Invoice\InvoiceFile;
use App\Models\Customer\Customer;
use App\Models\Invoice\InvoiceAction;

class Invoice extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'customer_id',
        'is_public',
        'status',
        'invoice_number',
        'reference',
        'invoice_date',
        'invoice_from',
        'currency_id',
        'sub_value',
        'vat_value',
        'total_value',
        'notes'
    ];

    protected $casts = [
        'status'       => InvoiceStatus::class,
        'invoice_date' => 'date',
        'is_public'    => 'boolean'
    ];

    /**
     * Get the invoice line items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }
    
    /**
     * Get the user that created the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the currency of the invoice.
     *
     * @return \App\Models\Currency\Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the invoice files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(InvoiceFile::class);
    }

    /**
     * Get the invoice customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the formatted sub total.
     *
     * @return string
     */
    public function getFormattedSubTotalAttribute()
    {
        return number_format($this->sub_value, 2);
    }

    /**
     * Get the formatted vat total.
     *
     * @return string
     */
    public function getFormattedVatTotalAttribute()
    {
        return number_format($this->vat_value, 2);
    }

    /**
     * Get the formatted total.
     *
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_value, 2);
    }

    /**
     * Get the invoice actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(InvoiceAction::class);
    }

    /**
     * Generate the invoice pdf.
     *
     * @return void
     */
    public function generate()
    {
        GenerateInvoice::dispatch($this); 
    }

    /**
     * Send the invoice email.
     *
     * @param  string|null  $cc
     * @param  string|null  $bcc
     * @return void
     */
    public function email($cc = null, $bcc = null)
    {
        SendInvoiceEmail::dispatch($this, $cc, $bcc);
    }
}
