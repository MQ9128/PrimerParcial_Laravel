<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
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
            'car_make' => ['sometimes', 'required', 'max:255'],
            'car_model' => ['sometimes', 'required', 'max:255'],
            'car_year' => ['sometimes', 'required', 'integer', 'min:1886', 'max:' . (date('Y') + 1)],
            'car_price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'car_status' => ['sometimes', 'boolean'],
            'category_id' => ['sometimes', 'required', 'integer', Rule::exists('categories', 'id')],
            'barcode' => ['sometimes', 'required', 'string'],
        ];
    }
}
