<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class ChildrenCategories extends Component
{
    public $categories;
    public $parentId;

    public function __construct($categories, $parentId = null)
    {
        $this->categories = $categories;
        $this->parentId = $parentId;
    }

    public function render()
    {
        return view('site.components.category.children-categories');
    }
}
