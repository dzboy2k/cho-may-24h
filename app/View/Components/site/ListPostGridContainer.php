<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class ListPostGridContainer extends Component
{
    public $posts;
    public $title;

    public const DEFAULT_COL = '12';
    public const DEFAULT_TOGGLE = 'hide';

    public ?string $xs;
    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;

    public ?string $showTime;
    public ?string $showAddress;
    public ?string $showProvider;
    public ?string $showProviderTop;
    public ?string $showSupport;
    public ?string $showPrice;

    public ?string $bg;
    public ?string $showSupportLimit;
    public ?string $viewMoreLink;


    public function __construct(
        $posts,
        $title,
        $viewMoreLink = null,
        $xs = self::DEFAULT_COL,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL,
        $md = self::DEFAULT_COL,
        $lg = self::DEFAULT_COL,
        $showPrice = self::DEFAULT_TOGGLE,
        $showAddress = self::DEFAULT_TOGGLE,
        $showProviderTop = self::DEFAULT_TOGGLE,
        $showProvider = self::DEFAULT_TOGGLE,
        $showSupport = self::DEFAULT_TOGGLE,
        $showTime = self::DEFAULT_TOGGLE,
        $showLimit = self::DEFAULT_TOGGLE,
        $bg = '',
    )
    {
        $this->viewMoreLink = $viewMoreLink;
        $this->posts = $posts;
        $this->title = $title;
        $this->xs = $xs;
        $this->mb = $mb;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
        $this->showTime = $showTime;
        $this->showAddress = $showAddress;
        $this->showProvider = $showProvider;
        $this->showProviderTop = $showProviderTop;
        $this->showSupport = $showSupport;
        $this->showPrice = $showPrice;
        $this->showSupportLimit = $showLimit;
        $this->bg = $bg;
    }

    public function render()
    {
        return view('site.components.post.list-post-grid-container');
    }
}