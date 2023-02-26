<?php

namespace App\Http\Requests;

use App\Enums\CurrencyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePriceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0.01',
            'currency' => ['required', new Enum(CurrencyEnum::class)],
            'product' => 'required|exists:products,name',
            'size' => 'required|exists:sizes,name',
            'category' => 'required|exists:categories,name',
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price is not a number.',
            'price.min' => 'The minimum value for price is 0.01',

            'currency.required' => 'The currency is required.',
            'currency.enum' => 'The currency is not valid.',

            'product.required' => 'The product name is required.',
            'product.exists' => 'This product do not exists.',

            'size.required' => 'The size name is required.',
            'size.exists' => 'This size do not exists.',

            'category.required' => 'The category name is required.',
            'category.exists' => 'This category do not exists.',
        ];
    }
}
