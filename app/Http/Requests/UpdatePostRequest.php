<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'status'     => 'nullable|in:pending,approved,rejected',
            'image'      => 'nullable|image|max:2048',
            'society_id' => 'required|exists:societies,id',
        ];
    }
}
