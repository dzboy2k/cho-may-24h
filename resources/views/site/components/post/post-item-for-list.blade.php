@php
    $authorId = $post->author->id;
    $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
    $imgTagRegex = config('constants.IMG_TAG_REGEX');
    $descriptionWithoutImages = preg_replace($imgTagRegex, '', $post->description);
@endphp
<a class="nav-link p-2" href="{{ route('post.detail', ['slug' => $post->slug]) }}">
    <div class="row p-2 my-2 bg-white">
        <div class="col-12 col-md-4">
            <img src="{{ asset(@$post->images[0]->path) }}" class="object-fit-cover post-image-list w-100"
                alt="{{ @$post->images[0]->alt }}">
        </div>
        <div class="col-12 col-md-8">
            <h1 class="mt-2 fx-h4 fw-regular mt-md-0">{{ $post->title }}</h1>
            <div class="my-3 post-description-shorten">
                {!! preg_replace($scriptTagRegex, '', $descriptionWithoutImages) !!}
            </div>
            <h5 class="text-danger my-2">{{ number_format($post->price, 0, '.', '.') }} {{ __('message.currency') }}
            </h5>
            <p class="subtitle fw-light neutral-400">{{ __('message.posted') }}
                {{ Carbon\Carbon::parse($post->release_date)->diffForHumans(Carbon\Carbon::now()) }}</p>
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset($post->author->avatar) }}"
                        class="object-fit-cover post-author-avt rounded-circle">
                    <div class="row ps-2">
                        <h3 class="subtitle fw-light my-0">{{ $post->author->name }}</h3>
                        @if (count($post->author->fullAddresses($authorId)) > 0)
                            <p class="caption fw-light my-0 text-muted">
                                {{ Str::limit($post->author->fullAddresses($authorId)[0], 50, '...') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
