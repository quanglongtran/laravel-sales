<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'phone' => 'required',
            'gender' => 'required',
            'avatar' => 'nullable|image|mimes:png,jpg,PNG,jpeg,webp',
            'password' => 'confirmed',
            'email' => 'required|email',
            'phone' => 'required',
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
                notify($error, null, 'error');
                return;
            }
        }

        \notify('Update user successfully', \null, 'success');
    }
}
