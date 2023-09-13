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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contract_id' => 'required|exists:contracts,id',
            'title' => 'required|string|max:255',
            'validity' => ['required', new Enum(PackValidityEnum::class)],
            'description' => 'nullable|string|max:255',
        ];
    }
}
