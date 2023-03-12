<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
            'code'          => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'exchange_rate' => 'required|numeric|min:0',
            'symbol'        => 'required|string|max:255',
        ];
    }
}
