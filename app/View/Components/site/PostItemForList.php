<?php

namespace App\View\Components\site;

use App\Models\Post;
use Illuminate\View\Component;

class PostItemForList extends Component
{
    public string $type;
    public Post $post;

    public function __construct($type, $post)
    {
        $this->type = $type;
        $this->post = $post;
    }

    public function render()
    {
        return view('site.components.post.post-item-for-list');
    }
}
