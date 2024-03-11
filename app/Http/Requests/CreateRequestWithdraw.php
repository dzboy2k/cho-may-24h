<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DivisibleBy;

class CreateRequestWithdraw extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can set authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fluctuation' => ['required', 'integer', new DivisibleBy(10000), 'min:50000'],
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_owner' => 'required|string|max:255',
            'bank_branch' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'fluctuation.required' => __('validation.fluctuation.required'),
            'fluctuation.integer' => __('validation.fluctuation.integer'),
            'fluctuation.min' => __('validation.fluctuation.min'),
            'fluctuation.divisible_by' => __('validation.fluctuation.divisible_by'),
            'bank_name.required' => __('validation.bank_name.required'),
            'bank_name.string' => __('validation.bank_name.string'),
            'bank_account.required' => __('validation.bank_account.required'),
            'bank_account.string' => __('validation.bank_account.string'),
            'bank_owner.required' => __('validation.bank_owner.required'),
            'bank_owner.string' => __('validation.bank_owner.string'),
            'bank_branch.required' => __('validation.bank_branch.required'),
            'bank_branch.string' => __('validation.bank_branch.string'),
        ];
    }
}
