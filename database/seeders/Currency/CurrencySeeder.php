<?php

namespace Database\Seeders\Currency;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Currency\Currency;
use App\Models\User;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'user_id' => 1,
            'code'   => 'USD',
            'name'   => 'US Dollar',
            'symbol' => '$',
            'exchange_rate' => 0.7,
            'is_archived' => false
        ]);

        Currency::create([
            'user_id' => 1,
            'code'   => 'EUR',
            'name'   => 'Euro',
            'symbol' => '€',
            'exchange_rate' => 0.84,
            'is_archived' => false
        ]);

        Currency::create([
            'user_id' => 1,
            'code'   => 'GBP',
            'name'   => 'British Pound',
            'symbol' => '£',
            'exchange_rate' => 1,
            'is_archived' => false
        ]);
    }
}
