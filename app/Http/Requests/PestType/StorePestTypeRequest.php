<?php

namespace App\Http\Requests\PestType;

use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StorePestTypeRequest extends FormRequest
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
            'photo' => [
                'nullable',
                File::image()
                ->max(5 * 1024),
            ],
            'name' => 'required|max:50|unique:pest_types',
            'description' => 'nullable',
            'pesticide_id' => 'required|exists:pesticides,id'
        ];
    }
}
