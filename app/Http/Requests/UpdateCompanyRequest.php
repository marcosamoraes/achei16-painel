<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
        $this->merge([
            'tags' => explode(',', $this->tags),
            'payment_methods' => implode(', ', $this->payment_methods),
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
            'client_id' => 'nullable|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'opening_hours' => 'nullable|string',
            'opening_24h' => 'nullable|boolean',
            'cep' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'google_my_business' => 'nullable|string|max:255',
            'ifood' => 'nullable|string|max:255',
            'waze' => 'nullable|string|max:255',
            'olx' => 'nullable|string|max:255',
            'google_street_view' => 'nullable|string|max:255',
            'payment_methods' => 'nullable|string|max:255',
            'image' => 'nullable|file',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file',
            'featured' => 'nullable|boolean',
            'status' => 'required|boolean',

            'categories' => 'nullable|array',
            'categories.*' => 'nullable|exists:categories,id',

            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ];
    }
}
