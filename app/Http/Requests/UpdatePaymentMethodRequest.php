<?php

namespace App\Http\Requests;

use App\Models\Payement_methods;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
        'name' => ['required','string','max:50',Rule::unique(Payement_methods::class)->ignore($this->user()->id)],
        'is_active' => 'boolean',
        'numero' => 'required|string|max:100',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
    ];

    }
}
