<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'token' => 'required|string',
            'order' => 'required|array|min:1',
            'restaurantId' => 'required|integer|min:1|exists:restaurants,id', //il campo è richiesto, deve essere un numero intero, il valore minimo è 1 e deve inoltre esistere nella tabella dei ristoranti paragonato con l'id
            'customerName' => 'required|string|max:255',
            'customerLastName' => 'required|string|max:255',
            'customerEmail' => 'required|email|max:255',
            'customerPhoneNumber' => 'required|numeric|max_digits:20|min_digits:3',
            'customerAddress' => 'required|min:4|max:255',
        ];
    }
}
