<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $birthDate = $this->seller['birth_date'] ?? null;

        if ($birthDate) {
            $birthDate = explode('/', $birthDate);
            $birthDate = $birthDate[2] . '-' . $birthDate[1] . '-' . $birthDate[0];
            $birthDate = date('Y-m-d', strtotime($birthDate));
        }

        $this->merge([
            'seller' => [
                ...$this->seller,
                'birth_date' => $birthDate
            ],
        ]);
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
            'seller.*' => 'nullable',
            'seller.cpf' => 'nullable|string|max:14',
            'seller.rg' => 'nullable|string|max:12',
            'seller.birth_date' => 'nullable|date',
            'seller.phone' => 'nullable|string|max:20',
            'seller.cep' => 'nullable|string|max:9',
            'seller.address' => 'nullable|string|max:255',
            'seller.number' => 'nullable|string|max:10',
            'seller.complement' => 'nullable|string|max:255',
            'seller.neighborhood' => 'nullable|string|max:255',
            'seller.city' => 'nullable|string|max:255',
            'seller.state' => 'nullable|string|max:2',
            'seller.commission' => 'nullable|numeric',
            'status' => 'required|boolean',
        ];
    }
}
