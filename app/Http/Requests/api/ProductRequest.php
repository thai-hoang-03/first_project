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
            'category' => 'required',
            'brand' => 'required',
            'name' => 'required|max:50|min:5',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg',
            'price' => 'required|integer',
            'description' => 'required',
            'company' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute Không được để trống',
            'max'=>':attribute cannot more than :max character',
            'min'=>':attribute cannot less than :min character',            
            'integer' =>':attribute only accepts number',
            'image' => 'Image only allow image file',
            'mimes' => 'Image must be a file of type: :values',
        ];
    }
}
