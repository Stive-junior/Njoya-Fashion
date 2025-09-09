<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:21048',
             'variants' => 'required|array|min:1',
        'variants.*.sizes' => 'required|array|min:1',
        'variants.*.sizes.*' => 'string|max:50',
        'variants.*.colors' => 'required|array|min:1',
        'variants.*.colors.*' => 'string|regex:/^#[0-9a-fA-F]{6}$/',
        'variants.*.materials' => 'nullable|array',
        'variants.*.materials.*' => 'string|max:50'
        ];
    }
}
