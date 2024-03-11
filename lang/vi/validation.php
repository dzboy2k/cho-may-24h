<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    |  following language lines contain  default error messages used by
    |  validator class. Some of se rules have multiple versions such
    | as  size rules. Feel free to tweak each of se messages here.
    |
    */
    'after' => 'Ngày phải lớn hơn ngày hiện tại',
    'file' => 'Phải có một file.',
    'confirmed' => 'Trường này không khớp.',
    'current_password' => 'Mật khẩu không đúng.',
    'email' => 'Trường này không đúng định dạng.',
    'max' => [
        'numeric' => 'Trường này phải nhỏ hơn hoặc bằng :max.',
        'file' => 'Trường này phải nhỏ hơn hoặc bằng :max kilobytes.',
        'string' => 'Trường này phải nhỏ hơn hoặc bằng :max ký tự.',
        'array' => 'Trường này phải ít hơn hoặc bằng :max.',
    ],
    'min' => [
        'numeric' => 'Trường này phải lớn hơn hoặc bằng :min.',
        'file' => 'Trường này phải lớn hơn hoặc bằng :min kilobytes.',
        'string' => 'Trường này phải lớn hơn hoặc bằng :min ký tự.',
        'array' => 'Trường này phải lớn hơn hoặc bằng :min.',
    ],
    'numeric' => 'Trường này phải là số.',
    'password' => ' password không chính xác.',
    'regex' => ' Trường này định dạng không đúng.',
    'required' => ' Trường này không được để trống.',
    'size' => [
        'numeric' => ' Trường này phải là :size.',
        'file' => ' Trường này phải là :size kilobytes.',
        'string' => ' Trường này phải có :size ký tự.',
        'array' => ' Trường này phải bao gồm :size vật phẩm.',
    ],
    'string' => ' Trường này phải là chuỗi.',
    'unique' => ' Trường này đã được sử dụng.',
    'fluctuation' => [
        'required' => 'Trường biến động là bắt buộc.',
        'integer' => 'Biến động phải là một số nguyên.',
        'divisible_by' => 'Biến động phải chia hết cho 10,000.',
        'min' => 'Biến động phải lớn hơn hoặc bằng 50,000.',
    ],
    'bank_name' => [
        'required' => 'Trường tên ngân hàng là bắt buộc.',
        'string' => 'Tên ngân hàng phải là một chuỗi.',
        'max' => 'Tên ngân hàng không được vượt quá :max ký tự.',
    ],
    'bank_account' => [
        'required' => 'Trường số tài khoản ngân hàng là bắt buộc.',
        'string' => 'Số tài khoản ngân hàng phải là một chuỗi.',
        'max' => 'Số tài khoản ngân hàng không được vượt quá :max ký tự.',
    ],
    'bank_owner' => [
        'required' => 'Trường chủ tài khoản là bắt buộc.',
        'string' => 'Chủ tài khoản phải là một chuỗi.',
        'max' => 'Chủ tài khoản không được vượt quá :max ký tự.',
    ],
    'bank_branch' => [
        'required' => 'Trường chi nhánh ngân hàng là bắt buộc.',
        'string' => 'Chi nhánh ngân hàng phải là một chuỗi.',
        'max' => 'Chi nhánh ngân hàng không được vượt quá :max ký tự.',
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using
    | convention "attribute.rule" to name  lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    |  following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [],
];
