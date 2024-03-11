<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class UserItemForGrid extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public const DEFAULT_COL = '12';

    public $user;

    public ?string $xs;
    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;
    public function __construct(
        $user,
        $xs = self::DEFAULT_COL,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL,
        $md = self::DEFAULT_COL,
        $lg = self::DEFAULT_COL,
    )
    {
        $this->user = $user;
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
        return view('site.components.user.user-item-for-grid');
    }
}