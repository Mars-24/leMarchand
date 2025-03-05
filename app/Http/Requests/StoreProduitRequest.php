<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
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
            'model' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB pour les images
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0|gte:prix_achat',
            'prix_minimum' => 'required|numeric|min:0|lte:prix_vente',
            'garantie' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
            'model.required' => 'Le modèle est obligatoire.',
            'model.string' => 'Le modèle doit être une chaîne de caractères.',
            'model.max' => 'Le modèle ne peut pas dépasser 255 caractères.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L’image doit être au format jpeg, png ou jpg.',
            'photo.max' => 'La taille de l’image ne peut pas dépasser 2 Mo.',
            'prix_achat.required' => 'Le prix d’achat est obligatoire.',
            'prix_achat.numeric' => 'Le prix d’achat doit être un nombre.',
            'prix_achat.min' => 'Le prix d’achat ne peut pas être négatif.',
            'prix_vente.required' => 'Le prix de vente est obligatoire.',
            'prix_vente.numeric' => 'Le prix de vente doit être un nombre.',
            'prix_vente.min' => 'Le prix de vente ne peut pas être négatif.',
            'prix_vente.gte' => 'Le prix de vente doit être supérieur ou égal au prix d’achat.',
            'prix_minimum.required' => 'Le prix minimum est obligatoire.',
            'prix_minimum.numeric' => 'Le prix minimum doit être un nombre.',
            'prix_minimum.min' => 'Le prix minimum ne peut pas être négatif.',
            'prix_minimum.lte' => 'Le prix minimum doit être inférieur ou égal au prix de vente.',
            'garantie.required' => 'La durée de garantie est obligatoire.',
            'garantie.integer' => 'La durée de garantie doit être un entier.',
            'garantie.min' => 'La garantie ne peut pas être inférieure à 1 jours.',
        ];
    }
}
