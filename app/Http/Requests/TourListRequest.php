<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourListRequest extends FormRequest
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
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sortBy' => Rule::in(['price']),
            'sortOrder' => Rule::in(['desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'sortBy' => 'The sortBy must be one of: price',
            'sortOrder' => 'The sortOrder must be one of: asc, desc',
        ];
    }
}
