<?php

namespace Database\Factories\Invoice;

use App\Models\Currency\Currency;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\Invoice\InvoiceStatus;

use App\Models\User;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\LineItem;
use App\Models\VATRule\VATRule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'        => 1,
            'customer_id'    => null,
            'is_public'      => $this->faker->boolean,
            'status'         => InvoiceStatus::AWAITING,
            'invoice_number' => $this->faker->unique()->randomNumber(8),
            'invoice_date'   => $this->faker->date(),
            'reference'      => $this->faker->unique()->randomNumber(8),
            'invoice_from'   => $this->faker->company,
            'currency_id'    => 1,
            'sub_value'      => 0,
            'vat_value'      => 0,
            'total_value'    => 0,
            'notes'          => 'TEST NOTES'
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function ($invoice) {
            $invoice->currency_id = 1;
            $invoice->customer_id = 1;

            try {
                $invoice->save();
            } catch (\Exception $e) {
                report($e);
                return;
            }

            $invoice->lineItems()->saveMany(
                LineItem::factory()->count(5)->create([
                    'invoice_id' => $invoice->id,
                    'vat_id'     => 1,
                ])
            );

            $subtotal = 0;
            $vat      = 0;
            $total    = 0;

            foreach ($invoice->lineItems as $lineItem) {
                $lineTotal = $lineItem->unit_price * $lineItem->quantity;
                $lineVAT   = $lineTotal * ($lineItem->vatRule->percentage / 100);

                $subtotal += $lineTotal;
                $vat      += $lineVAT;
                $total    += $lineTotal + $lineVAT;

                $lineItem->vat_value = $lineVAT;
                $lineItem->total     = $lineTotal + $lineVAT;

                try {
                    $lineItem->save();
                } catch (\Exception $e) {
                    report($e);
                    return;
                }
            }

            $invoice->sub_value   = $subtotal;
            $invoice->vat_value   = $vat;
            $invoice->total_value = $total;

            try {
                $invoice->save();
            } catch (\Exception $e) {
                report($e);
                return;
            }
        });
    }
}
