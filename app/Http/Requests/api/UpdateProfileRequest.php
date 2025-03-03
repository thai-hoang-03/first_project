<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:200'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống !',
            'max' => ':attribute không được quá :max ký tự !',
            'avatar' => ':attribute phải là hình ảnh !',
            'mimes' => ':attribute phải có định dạng như sau: jpeg,png,jpg,gif ',
            'avatar.max' => ':attribute Maximum file size to upload :max !'
        ];
    }
}
