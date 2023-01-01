<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'sale' => 'required',
            'price' => 'required',
            'category_ids' => 'required|array',
            'details' => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                \notify($error, null, 'error');
            }
            return;
        }

        \notify('Create product successfully', \null, 'success');
    }
}
