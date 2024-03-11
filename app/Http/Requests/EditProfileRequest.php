<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|in:0,1,2',
            'dob' => 'nullable|date',
            'introduce' => 'nullable|string|max:10000',
            'issue' => 'nullable|date',
            'address' => 'nullable|string|max:10000',
            'identify_code' => 'nullable|string|max:20',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'ward_id' => 'nullable',
            'street_address' => 'nullable|string|max:10000',
            'full_address' => 'nullable|string|max:10000',
        ];
    }
}
