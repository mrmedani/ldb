<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wilaya_id' => ['required', 'exists:wilayas,id'],
            'commune' => ['nullable', 'string', 'max:200'],
            'company_name' => ['required', 'string', 'max:200'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string'],
            'google_maps' => ['nullable', 'string', 'url', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'wilaya_id.required' => 'Veuillez sélectionner une wilaya.',
            'wilaya_id.exists' => 'La wilaya sélectionnée est invalide.',
            'company_name.required' => 'Le nom de l\'entreprise est requis.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'address.required' => 'L\'adresse est requise.',
            'google_maps.url' => 'Le lien Google Maps doit être une URL valide.',
        ];
    }
}
