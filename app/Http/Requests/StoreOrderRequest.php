<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            "order_number" => "required|string",
            "produits" => "required|json",
            'mode_achat' => "required|in:deal,paiement,acompte",
            'prix_total' => 'required|numeric|min:0',

        ];
    }
    public function messages()
    {
        return [
            'order_number.required' => 'Le numéro de commande est requis.',
            'order_number.string' => 'Le numéro de commande doit être une chaîne de caractères.',

            'produits.required' => 'Le champ des produits est requis.',
            'produits.json' => 'Le champ des produits doit être un JSON valide.',
            'prix_total.required' => 'Le prix total est requis.',
            'prix_total.numeric' => 'Le prix total doit être un nombre.',
            'prix_total.min' => 'Le prix total ne peut pas être inférieur à 0.',
            'mode_achat.required' => 'Le mode d\'achat est obligatoire.',
            'mode_achat.in' => 'Le mode d\'achat doit être l\'une des valeurs suivantes : deal, paiement, acompte.',
        ];
    }
}
