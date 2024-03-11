<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class ListPageGridContainer extends Component
{
    public $pages;
    public $title;

    public const DEFAULT_COL = '12';
    public const DEFAULT_TOGGLE = 'hide';

    public ?string $xs;
    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;
    public function __construct(
        $pages,
        $title,
        $xs = self::DEFAULT_COL,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL,
        $md = self::DEFAULT_COL,
        $lg = self::DEFAULT_COL,
    )
    {
        $this->pages = $pages;
        $this->title = $title;
        $this->xs = $xs;
        $this->mb = $mb;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('site.components.page.list-page-grid-container');
    }
}