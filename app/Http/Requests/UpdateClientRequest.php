<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->email . ',email',
            'client.*' => 'nullable',
            'client.cpf_cnpj' => 'nullable|string',
            'client.phone' => 'nullable|string|max:20',
            'client.phone2' => 'nullable|string|max:20',
            'client.cep' => 'nullable|string|max:9',
            'client.address' => 'nullable|string|max:255',
            'client.number' => 'nullable|string|max:10',
            'client.complement' => 'nullable|string|max:255',
            'client.neighborhood' => 'nullable|string|max:255',
            'client.city' => 'nullable|string|max:255',
            'client.state' => 'nullable|string|max:2',
            'status' => 'required|boolean',
        ];
    }
}
