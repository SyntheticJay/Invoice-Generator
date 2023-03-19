<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Country\CountrySeeder::class,
            User\UserSeeder::class,
            Customer\CustomerSeeder::class,
            Currency\CurrencySeeder::class,
            VATRule\VATRuleSeeder::class,
            // FIX: Invoice\InvoiceSeeder::class,
            Invoice\InvoiceFileSeeder::class,
            DefaultSetting\DefaultSettingSeeder::class,
        ]);
    }
}
