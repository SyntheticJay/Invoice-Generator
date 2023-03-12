<?php

namespace Database\Seeders\Country;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Country::withoutEvents(function () {
                Country::factory()->count(10)->create();
            });
        } catch (\Exception $e) {
            report($e);
            return;
        }
    }
}
