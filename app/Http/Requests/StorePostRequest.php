<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'      => 'required|string|max:255',
            'body'       => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image'      => 'nullable|image|max:2048', // optional image ≤2MB
            'society_id' => 'required|exists:societies,id',
        ];
    }
}
