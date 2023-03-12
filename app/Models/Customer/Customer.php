<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country\Country;
use App\Models\Invoice\Invoice;

use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'addr_line_1',
        'addr_line_2',
        'city',
        'county',
        'postcode',
        'country_id',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    /**
     * Get all of the invoices for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the country that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the address of the customer
     *
     * @return string
     */
    public function address()
    {
        return $this->addr_line_1 . ', ' . 
               $this->addr_line_2 . ', ' . 
               $this->city . ', ' . 
               $this->county . ', ' . 
               $this->postcode . ', ' . 
               $this->country->name;
    }
}
