<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;

use App\Models\Customer\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Customer::factory()->count(10)->create();
        } catch (\Exception $e) {
            report($e);
            return;
        }
    }
}
