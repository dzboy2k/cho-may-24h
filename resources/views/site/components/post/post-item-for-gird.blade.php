@php
    $authorId = $post->author->id;
@endphp
<div
    class="col-{{ $mb }} col-sm-{{ $sm }} col-md-{{ $md }} col-lg-{{ $lg }} px-2 border border-light post-item-container">
    <a class="py-1 px-0 nav-link" href="{{ route('post.detail', ['slug' => $post->slug]) }}"
        style="background-color: {{ $bg }}">
        <img src="{{ asset(@$post->images[0]->path) }}" class="object-fit-cover w-100 post-image-grid rounded-1"
            alt="{{ @$post->images[0]->alt }}">
        <div class="d-flex justify-content-start align-items-center mb-1 mt-3" style="height: 18px">
            @if ($support === 'show')
                <button
                    class="bg-primary border-0 text-white rounded-1 me-2 d-flex justify-content-center align-items-center p-1">
                    <img src="{{ asset('images/provider.svg') }}" class="object-fit-cover icon-tag-item"
                        alt="support-image">
                    <span class="caption-tag-item fw-medium">{{ __('post_detail.depre_support') }}</span>
                </button>
            @endif
            @if ($post->is_partner !== 0 && $provider === 'hide' && $providerTop === 'show')
                <button
                    class="provider-bg border-0 text-white rounded-1 d-flex justify-content-center align-items-center p-1">
                    <img src="{{ asset('images/provider.svg') }}" class="object-fit-cover icon-tag-item"
                        alt="provider-image">
                    <span class="caption-tag-item fw-medium">{{ __('post_detail.provider') }}</span>
                </button>
            @endif
        </div>
        <h1 class="fw-medium mt-1 mb-1 post-item-title">
            {{ $post->title }}
        </h1>
        @if ($price === 'show')
            <h3 class="text-danger post-item-price mb-1 mt-0"><span
                    class="text-black fw-light">{{ __('post_detail.price') }}:</span>
                {{ number_format($post->price, 0, '.', '.') }}
                {{ __('wallet.vnd') }}</h3>
        @endif
        @if ($post->is_partner !== 0 && $provider === 'show')
            <div class="d-inline-flex">
                <button
                    class="provider-bg border-0 text-white rounded-1 d-flex justify-content-center align-items-center p-1">
                    <img src="{{ asset('images/provider.svg') }}" class="object-fit-cover icon-tag-item"
                        alt="provider-image" />
                    <span class="caption-tag-item fw-light">{{ __('post_detail.provider') }}</span>
                </button>
            </div>
        @endif
        @if ($supportLimit === 'show')
            <h3 class="post-item-support fw-light mb-1 mt-0">{{ __('post_detail.depre_support_limit') }}
                <span class="text-primary fw-medium">
                    {{ number_format($post->support_limit, 0, '.', '.') }}{{ __('wallet.vnd') }}
                </span>
            </h3>
        @endif
        <div class="d-flex">
            @if ($time === 'show')
                <div class="neutral-300 me-1 post-item-caption">
                    {{ \Carbon\Carbon::parse($post->release_date)->diffForHumans(Carbon\Carbon::now()) }}</div>
            @endif
            @if ($address === 'show' && count($post->author->fullAddresses($authorId)) > 0)
                <span class="neutral-300 post-item-caption">{{ $post->author->fullAddresses($authorId)[0] }}
                </span>
            @endif
        </div>
    </a>
</div>
