<?php

namespace App\Traits\Requests;

use App\Models\VATRule\VATRule;

/**
 * Designed to work with the prepareForValidation() method.
 * 
 * We do this so we can prevent the user from altering the total values in the request.
 */
trait CalculatesInvoiceTotals
{
    public function calculate()
    {
        $subtotal  = 0;
        $vat       = 0;
        $total     = 0;
        $lineItems = [];

        if (!$this->line_items) {
            return;
        }

        foreach ($this->line_items as $lineItem) {
            $percentage = VATRule::find($lineItem['vat_id'])->percentage;
            $lineTotal  = $lineItem['unit_price'] * $lineItem['quantity'];
            $vatValue   = $lineTotal * ($percentage / 100);

            $subtotal += $lineTotal;
            $vat      += $vatValue;
            $total    += $lineTotal + $vatValue;

            $lineItem['vat_value'] = $vatValue;
            $lineItem['total']     = $lineTotal + $vatValue;

            $lineItems[] = $lineItem;
        }

        $this->merge([
            'sub_value'   => $subtotal,
            'vat_value'   => $vat,
            'total_value' => $total,
            'line_items'  => $lineItems,
        ]);
    }
}