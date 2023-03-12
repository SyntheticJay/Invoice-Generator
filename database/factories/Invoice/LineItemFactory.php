<?php

namespace Database\Factories\Invoice;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\VATRule\VATRule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice\LineItem>
 */
class LineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'quantity'    => $this->faker->randomNumber(2),
            'unit_price'  => $this->faker->randomFloat(2, 0, 1000),
            'vat_value'   => 0,
            'total'       => 0,
        ];
    }
}
