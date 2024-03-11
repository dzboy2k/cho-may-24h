<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "required|min:3|max:20",
            "phone" => "required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|size:10",
            "email" => "required|email|unique:users",
            "password" => "required|min:8|max:20|confirmed",
            "password_confirmation" => "required|min:8|max:20",
            "referral_code" => "nullable"
        ];
    }
}
