<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class PageItemForGrid extends Component
{
    public const DEFAULT_COL = '12';
    public const DEFAULT_TOGGLE = 'hide';

    public $page;
    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;
    public function __construct(
        $page,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL,
        $md = self::DEFAULT_COL,
        $lg = self::DEFAULT_COL,
    )
    {
        $this->page = $page;
        $this->mb = $mb;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
    }


    public function render()
    {
        return view('site.components.page.page-item-for-grid');
    }
}