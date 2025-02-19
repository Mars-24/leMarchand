<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
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
            "nom"=>"required|string",        
            'categorie_id' => 'required|exists:categories,id'

        ];
    }
    public function messages()
    {
        return[
            'nom.required' => 'Le nom de la sous-catégorie est obligatoire.',
        'nom.string' => 'Le nom doit être une chaîne de caractères valide.',
        'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
        'nom.unique' => 'Ce nom de sous-catégorie existe déjà.',
        'categorie_id.required' => 'La catégorie est obligatoire.',
        'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ];
    }
}
