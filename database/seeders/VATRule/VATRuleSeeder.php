<?php

namespace Database\Seeders\VATRule;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\VATRule\VATRule;
use App\Models\User;

class VATRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VATRule::create([
            'user_id'     => 1,
            'name'        => 'Zero Rated',
            'description' => 'Zero Rated VAT',
            'percentage'  => 0,
            'vat_code'    => '0',
            'nominal_vat' => '0',
            'is_archived' => false
        ]);

        VATRule::create([
            'user_id'     => 1,
            'name'        => 'Standard Rated',
            'description' => 'Standard Rated VAT',
            'percentage'  => 20,
            'vat_code'    => '20',
            'nominal_vat' => '20',
            'is_archived' => false
        ]);
    }
}
