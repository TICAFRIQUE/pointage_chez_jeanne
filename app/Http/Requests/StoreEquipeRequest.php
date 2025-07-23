<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipeRequest extends FormRequest
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
            'nom' => 'required|string|max:100',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de l’équipe est requis.',
            'nom.string' => 'Le nom de l’équipe doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de l’équipe ne doit pas dépasser 100 caractères.',

            'heure_debut.required' => 'L’heure de début est requise.',
            'heure_debut.date_format' => 'Le format de l’heure de début est invalide.',

            'heure_fin.required' => 'L’heure de fin est requise.',
            'heure_fin.date_format' => 'Le format de l’heure de fin est invalide.',
            'heure_fin.after' => 'L’heure de fin doit être après l’heure de début.',
        ];
    }
}
