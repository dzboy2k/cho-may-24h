<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
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
        $max_support_time = setting('site.max_support_time');
        return [
            'images.*' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'images' => 'max:6',
            'price' => 'required|numeric|min:1',
            'support_limit' => 'required|numeric|min:1',
            'support_limit_receive' => 'required|numeric|min:1',
            'support_time' => 'required|min:1|max:' . $max_support_time,
            'category' => 'required|numeric',
            'status' => 'required|numeric',
            'brand' => 'required|numeric',
            'introduce' => 'required',
            'title' => 'required|max:50',
            'description' => 'required|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'images.max' => 'Chỉ được đăng tối đa 6 ảnh',
            'images.*.max' => 'Mỗi ảnh có dung lượng tối đa là 2MB',
            'images.*.mine' => 'Định dạng ảnh không được hỗ trợ'
        ];
    }
}
