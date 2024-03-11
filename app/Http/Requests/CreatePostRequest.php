<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends FormRequest
{
    protected function getCreatePostRule()
    {
        return [
            'images.*' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'images' => 'max:6',
            'slug' => 'required:unique:posts',
            'price' => 'required|numeric|min:1',
            'support_limit_receive' => 'required|numeric|min:0',
            'support_time' => 'required|min:1|max:' . setting('site.max_support_time'),
            'category' => 'required|numeric',
            'status' => 'required|numeric',
            'brand' => 'required|numeric',
            'introduce' => 'nullable|max:5000',
            'title' => 'required|max:50',
            'description' => 'required|max:5000',
        ];
    }

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
        return $this->getCreatePostRule();
    }

    public function messages()
    {
        return [
            'images.max' => 'Chỉ được đăng tối đa 6 ảnh',
            'images.*.max' => 'Mỗi ảnh có dung lượng tối đa là 2MB',
            'images.*.mine' => 'Định dạng ảnh không được hỗ trợ',
        ];
    }
}
