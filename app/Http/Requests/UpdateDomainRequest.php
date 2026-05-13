<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'in:#6366f1,#10b981,#f59e0b,#f43f5e,#06b6d4,#8b5cf6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'color.required' => 'La couleur est obligatoire.',
            'color.in' => 'La couleur sélectionnée n\'est pas valide.',
        ];
    }
}
