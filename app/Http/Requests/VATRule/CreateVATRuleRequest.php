<?php

namespace App\Http\Requests\VATRule;

use Illuminate\Foundation\Http\FormRequest;

class CreateVATRuleRequest extends FormRequest
{
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'percentage'  => 'required|numeric',
            'vat_code'    => 'nullable|string|max:255',
            'nominal_vat' => 'nullable|string|max:255',
        ];
    }
}
