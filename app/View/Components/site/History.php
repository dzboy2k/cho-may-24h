<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class History extends Component
{
    public $listHeaderKeyLang;
    public $listHistory;
    public $paginationRender;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($listHeaderKeyLang, $listHistory, $paginationRender = null)
    {
        $this->listHeaderKeyLang = $listHeaderKeyLang;
        $this->listHistory = $listHistory;
        $this->paginationRender = $paginationRender;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('site.components.history.history_component');
    }
}
