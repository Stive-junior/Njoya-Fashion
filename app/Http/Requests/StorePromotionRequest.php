<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
        'name' => 'required|string|max:100',
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'applies_to' => 'required|in:all,category,product',
        'target_id' => 'required_if:applies_to,category,product|nullable|exists:'. 
            ($this->applies_to === 'category' ? 'categories,id' : 'articles,id'),
        'start_date' => 'required|date|after:now',
        'end_date' => 'required|date|after:start_date',
        'min_order_amount' => 'nullable|numeric|min:0'
    ];

    }
}
