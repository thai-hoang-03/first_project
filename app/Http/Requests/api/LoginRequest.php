<?php

namespace App\Http\Requests\api;

use App\Http\Requests\api\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|max:200',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return[
            'required'=>':attribute Không được để trống',
            'email' => ':attribute sai định dạng',
            'password.min' => ':attribute phải có ít nhất :min ký tự'
        ];
    }
}

