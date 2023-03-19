<?php

namespace App\Http\Requests\Invoice;

use Carbon\Carbon;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\Requests\CalculatesInvoiceTotals;

class CreateInvoiceRequest extends FormRequest
{
    use CalculatesInvoiceTotals;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id'    => 'required|integer|exists:customers,id',
            'currency_id'    => 'required|integer|exists:currencies,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'invoice_date'   => 'required|string',
            'reference'      => 'required|string|max:255',
            'sub_value'      => 'required|numeric',
            'vat_value'      => 'required|numeric',
            'total_value'    => 'required|numeric',
            'line_items'     => 'required|array',
            'send_email'     => 'nullable'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        if ($this->invoice_date) {
            $this->merge([
                'invoice_date' => Carbon::createFromFormat('d/m/Y', $this->invoice_date)->toDateString()
            ]);
        }

        $this->calculate();
    }
}
