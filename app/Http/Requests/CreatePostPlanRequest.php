<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostPlanRequest extends FormRequest
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
    public function getRules($is_add)
    {
        $rule = [
            'title' => 'required|max:255',
            'summary' => 'required|max:255',
            'description' => 'required|max:5000',
            'price_per_month' => 'required|min:1|max:2000000000'
        ];
        if ($is_add) {
            $rule['image'] = 'required|image';
        }
        return $rule;
    }

    public function rules()
    {
        return $this->getRules(true);
    }
}
