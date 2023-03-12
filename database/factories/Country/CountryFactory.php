<?php

namespace Database\Factories\Country;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->country,
            'code'          => $this->faker->countryCode,
            'currency'      => $this->faker->currencyCode,
            'currency_code' => $this->faker->currencyCode,
            'currency_symbol' => $this->faker->currencyCode
        ];
    }
}
