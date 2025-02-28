<?php

namespace App\Http\Requests\api;
use App\Http\Requests\api\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute Không được để trống',
            'max'=>':attribute Không được quá :max ký tự',
            'email' => ':attribute sai định dạng',
            'email.unique' => ':attribute da ton tai',
            'password.min' => ':attribute phải có ít nhất :min ký tự',
            'avatar' => ':attribute phai la hình ảnh',
            'mimes' => ':attribute phai dinh dang như sau:jpeg,png,jpg,gif',
            'avatar.max' => ':attribute Maximum file size to upload :max'
        ];
    }

}