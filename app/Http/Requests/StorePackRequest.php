<?php

namespace App\Http\Requests;

use App\Http\Enums\PackValidityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePackRequest extends FormRequest
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
            'value' => str_replace(['.', ','], ['', '.'], $this->value),
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
            'contract_id' => 'required|exists:contracts,id',
            'title' => 'required|string|max:255',
            'value' => 'required|numeric',
            'validity' => ['required', new Enum(PackValidityEnum::class)],
            'description' => 'nullable|string|max:255',
        ];
    }
}
