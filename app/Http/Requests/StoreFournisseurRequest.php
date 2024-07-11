<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFournisseurRequest extends FormRequest
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
            //
            "nom"=>"required|string",
            "prenoms"=>"string|nullable",
            "telephone"=>"string|nullable",
            "email"=>"email|nullable",
            "photo"=>"image|nullable|mimes:jpg,png",
            
        ];
    }
    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
        ];
    }
}
