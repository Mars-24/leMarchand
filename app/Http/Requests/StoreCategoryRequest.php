<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "photo"=>"required|mimes:png,jpg",
        ];
    }

    public function messages()
    {
        return[
            "nom.required"=>"Veuillez entrer un nom",
            "photo.required"=>"Veuillez ajouter une photo",
            "photo.mimes"=>"Veuillez entrer un format de photo valide(png,jpg)",
        ];
    }
}
