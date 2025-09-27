<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'car_make' => ['required', 'max:255'],
            'car_model' => ['required', 'max:255'],
            'car_year' => ['required', 'integer', 'min:1886', 'max:' . (date('Y') + 1)],
            'car_price' => ['required', 'numeric', 'min:0'],
            'car_status' => ['boolean'],
        ];
    }
}
