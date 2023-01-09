<?php

namespace App\Http\Requests\CartProduct;

use Illuminate\Foundation\Http\FormRequest;

class CreateCartProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'size' => 'required',
            'quantity' => 'required|integer',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }
}
