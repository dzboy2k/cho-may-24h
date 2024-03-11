@php
    $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
@endphp
<div
    class="col-{{ $mb }} col-sm-{{ $sm }} col-md-{{ $md }} col-lg-{{ $lg }} px-2 border border-light page-item-container">
    <a class="py-1 px-0 nav-link" href="{{ route('site.pages', ['slug' => $page->slug]) }}">
        <img src="{{ asset(@$page->image) }}" class="object-fit-cover w-100 page-image-grid rounded-1" />
        <h1 class="fw-medium mt-1 mb-1 post-item-title">
            {{ $page->title }}
        </h1>
        <p class="subtitle fw-medium">{!! strlen($page->body) > 50
            ? preg_replace($scriptTagRegex, '', html_entity_decode(substr($page->body, 0, 50))) . '...'
            : preg_replace($scriptTagRegex, '', html_entity_decode($page->body)) !!}</p>
    </a>
</div>
