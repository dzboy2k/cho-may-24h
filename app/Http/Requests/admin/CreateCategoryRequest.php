<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'order' => 'required|numeric|min:1|max:100',
            'slug' => 'required|unique:categories',
            'image' => 'required|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'image.max' => 'Ảnh tối đa 2mb dung lượng'
        ];
    }
}
