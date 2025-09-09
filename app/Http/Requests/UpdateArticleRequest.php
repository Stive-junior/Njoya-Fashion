<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
        'base_price' => 'required|numeric|min:100',
        'category_id' => 'required|exists:categories,id',
        'images' => 'sometimes|array|max:10',
         'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:21048',
        'existing_images' => 'sometimes|array',
        'existing_images.*' => 'exists:images,id,article_id,'.$this->article->id,
        'deleted_images' => 'sometimes|array',
        'deleted_images.*' => 'exists:images,id,article_id,'.$this->article->id,
        'variants' => 'required|array|min:1',
        'variants.*.sizes' => 'required|array|min:1',
        'variants.*.sizes.*' => 'string|max:50',
        'variants.*.colors' => 'required|array|min:1',
        'variants.*.colors.*' => 'string|regex:/^#[0-9A-Fa-f]{6}$/',
        'variants.*.materials' => 'nullable|array',
        'variants.*.materials.*' => 'string|max:50'
    ];
}
}
