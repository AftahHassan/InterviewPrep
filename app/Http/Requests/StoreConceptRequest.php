<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'explanation' => ['nullable', 'string'],
            'difficulty' => ['required', 'in:junior,mid,senior'],
            'status' => ['required', 'in:to_review,in_progress,mastered'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'difficulty.required' => 'La difficulté est obligatoire.',
            'difficulty.in' => 'La difficulté sélectionnée n\'est pas valide.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné n\'est pas valide.',
        ];
    }
}
