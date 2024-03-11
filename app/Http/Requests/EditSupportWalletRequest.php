<?php

namespace App\Http\Requests;

class EditSupportWalletRequest extends EditUserWalletRequest
{

    public function rules()
    {
        return array_merge(parent::rules(), ['expired_date' => 'required|date|after:now']);
    }
}
