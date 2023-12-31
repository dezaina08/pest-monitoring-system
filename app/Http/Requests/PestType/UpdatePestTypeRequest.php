<?php

namespace App\Http\Requests\PestType;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePestTypeRequest extends FormRequest
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
            'name' => [
                'required',
                'max:50',
                Rule::unique('pest_types')->ignore($this->id)
            ],
            'description' => 'nullable',
            'pesticides' => 'nullable|array',
        ];
    }
}
