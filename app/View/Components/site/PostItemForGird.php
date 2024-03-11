<?php

namespace App\View\Components\site;

use App\Models\Post;
use Illuminate\View\Component;

class PostItemForGird extends Component
{
    public const DEFAULT_COL = '12';
    public const DEFAULT_TOGGLE = 'hide';

    public Post $post;
    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;

    public ?string $time;
    public ?string $address;
    public ?string $provider;
    public ?string $providerTop;
    public ?string $support;
    public ?string $price;
    public ?string $bg;
    public ?string $supportLimit;

    public function __construct(
        $post,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL,
        $md = self::DEFAULT_COL,
        $lg = self::DEFAULT_COL,
        $price = self::DEFAULT_TOGGLE,
        $address = self::DEFAULT_TOGGLE,
        $providerTop = self::DEFAULT_TOGGLE,
        $provider = self::DEFAULT_TOGGLE,
        $support = self::DEFAULT_TOGGLE,
        $time = self::DEFAULT_TOGGLE,
        $limit = self::DEFAULT_TOGGLE,
        $bg = '',
        )
    {
        $this->post = $post;
        $this->mb = $mb;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
        $this->time = $time;
        $this->address = $address;
        $this->provider = $provider;
        $this->providerTop = $providerTop;
        $this->support = $support;
        $this->price = $price;
        $this->supportLimit = $limit;
        $this->bg = $bg;
    }

    public function render()
    {
        return view('site.components.post.post-item-for-gird');
    }
}
