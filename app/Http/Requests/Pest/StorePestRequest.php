<?php

namespace App\Http\Requests\Pest;

use Illuminate\Foundation\Http\FormRequest;

class StorePestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pest_image_id' => 'required|integer',
            'pest_types' => 'required',
            'date_captured' => 'required|date',
        ];
    }
}
