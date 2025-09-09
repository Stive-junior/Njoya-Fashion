<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

    return [
        'name' => 'required|string|max:50|unique:payment_methods',
        'is_active' => 'boolean',
        'numero' => 'required|string|max:100',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:21048'
    ];

    }
}
