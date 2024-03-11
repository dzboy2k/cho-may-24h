<?php

namespace App\Http\Requests;

class EditPostRequest extends CreatePostRequest
{
    public function rules()
    {
        $create_post_rules = $this->getCreatePostRule();
        $create_post_rules['id'] = 'required|numeric';
        return $create_post_rules;
    }
}
