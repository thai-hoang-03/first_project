<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     */
    public function rules(): array
    {
        $userId = $this->route('id'); // Lấy ID user từ route

        return [
            'name' => 'nullable|string|max:200',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:200'
        ];
    }

    public function messages()
    {
        return [
            'max' => ':attribute không được quá :max ký tự!',
            'avatar.image' => ':attribute phải là hình ảnh!',
            'mimes' => ':attribute phải có định dạng như sau: jpeg, png, jpg, gif!',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự!'
        ];
    }
}
