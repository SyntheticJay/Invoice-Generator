<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'     => 1,
            'name'        => $this->faker->name,
            'email'       => $this->faker->unique()->safeEmail,
            'phone'       => $this->faker->phoneNumber,
            'addr_line_1' => $this->faker->streetAddress,
            'addr_line_2' => $this->faker->secondaryAddress,
            'city'        => $this->faker->city,
            'county'      => $this->faker->state,
            'postcode'    => $this->faker->postcode,
            'country_id'  => $this->faker->numberBetween(1, 10),
            'is_archived' => false,
        ];
    }
}
