<?php

namespace App\Http\Requests\api;

use App\Http\Requests\api\FormRequest;


class productRequest extends FormRequest
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
            'name' => 'required|string|max:20',
            'price' => 'required|integer|min:0',
            'description' => 'required|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống !',
            'max' => ':attribute không được quá :max ký tự ',
            'min' => ':attribute không được nhỏ hơn :min'
        ];
    }
}
