<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Currency\Currency;
use App\Models\Customer\Customer;
use App\Models\VATRule\VATRule;
use App\Models\Invoice\Invoice;
use App\Models\DefaultSetting\DefaultSetting;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the sessions for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the currencies for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    /**
     * Get the VAT rules for the user. 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vatRules()
    {
        return $this->hasMany(VATRule::class);
    }

    /**
     * Get the customers for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the invoices for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the default settings for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function defaultSettings()
    {
        return $this->hasMany(DefaultSetting::class);
    }
}
