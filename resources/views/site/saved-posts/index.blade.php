@extends('site.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
@endsection
@section('content')
    @php
        $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
        $imgTagRegex = config('constants.IMG_TAG_REGEX');
        $userId = Auth::id();
    @endphp
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-lg-3 mx-auto content-bounce-margin d-flex justify-content-center align-self-center">
            <div class="col-12 col-lg-10 row mx-1">
                <div class="card rounded-0 border-0">
                    <h5 class="fs-5 ms-2 mt-3">{{ __('user_info.saved_posts') }}</h5>
                    <div class="card-body">
                        @foreach ($listSavedPosts as $savedPost)
                            @php
                                $descriptionWithoutImages = preg_replace($imgTagRegex, '', $savedPost->post->description);
                            @endphp
                            <div class="container border saved-posts-item">
                                <div class="row">
                                    <a href="{{ route('post.detail', ['slug' => $savedPost->post->slug]) }}"
                                        class="col-12 col-md-10 row text-decoration-none text-reset mx-0 px-0">
                                        <div class="col-5 col-md-4 col-lg-3 mx-0 px-0">
                                            @if ($image = $savedPost->post->images->first())
                                                <img src="{{ asset($image->path) }}" alt="{{ $image->alt }}"
                                                    class="object-fit-cover img-fluid saved-post-img my-1 rounded-2 ms-2">
                                            @endif
                                        </div>
                                        <div class="col-7 col-md-8 col-lg-9 column align-self-center">
                                            <h6 class="fs-6 fw-medium title-saved-posts mb-0">{{ $savedPost->post->title }}
                                            </h6>
                                            <div class="caption text-muted post-desc-shorten my-1">
                                                {!! preg_replace($scriptTagRegex, '', $descriptionWithoutImages) !!}
                                            </div>
                                            <span class="subtitle fw-medium">{{ __('post_detail.price') }}: <span
                                                    class="text-danger">{{ number_format($savedPost->post->price, 0, '', '.') }}
                                                    {{ __('wallet.vnd') }}</span>
                                            </span>
                                            <p class="caption text-muted text-truncate fw-light">
                                                {{ __('user_info.posted') }}
                                                {{ \Carbon\Carbon::parse($savedPost->post->release_date)->diffForHumans(Carbon\Carbon::now()) }}
                                            </p>
                                        </div>
                                    </a>
                                    <div class="col-12 col-md-2 d-flex justify-content-end align-items-center mt-0 mb-1">
                                        @if ($userId !== $savedPost->post->author_id)
                                            <a href="{{ route('chat', ['receiver_id' => $savedPost->post->author_id, 'post_id' => $savedPost->post->id]) }}"
                                                class="btn btn-primary p-1 rounded-2 border-0 d-flex align-items-center me-1">
                                                <img src="{{ asset('images/chat.svg') }}" class="object-fit-contain"
                                                    alt="chat icon">
                                                <span class="caption"> {{ __('user_info.chat') }} </span>
                                            </a>
                                        @endif
                                        <a data-saved-post-btn = "{{ $savedPost->post->id }}"
                                            class="saved-post-btn btn btn-outline p-1 rounded-2 border d-flex align-items-center">
                                            <img src="{{ asset('images/heart-fill.svg') }}" alt="image heart" /></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        {{ $listSavedPosts->onEachSide(1)->links('site.components.pagination.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.saved-post-btn').click(async function() {
                let postId = $(this).data('saved-post-btn');
                let savedPostButton = $(this).closest('.saved-post-btn').find('img');
                try {
                    const resp = await fetch(`{{ route('toggle.save.post', ['id' => ':id']) }}`
                        .replace(':id', postId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                apiKey: authToken,
                            },
                            body: JSON.stringify({
                                postId: postId
                            })
                        });
                    if (resp.ok) {
                        const data = await resp.json();
                        showToast('info', 'Thông báo', data.message, {
                            position: 'topRight'
                        });
                        if (data.isSavedPost) {
                            savedPostButton.attr('src',
                                '{{ asset('images/heart-fill.svg') }}');

                        } else {
                            savedPostButton.attr('src', '{{ asset('images/heart.svg') }}');
                        }
                        setTimeout(()=>{
                            window.location.assign(window.location.href);
                        },1000)
                    } else {
                        const error = await resp.json();
                        showToast('error', 'Lỗi', error.message, {
                            position: 'topRight'
                        });
                    }
                } catch (error) {
                    showToast('error', 'Lỗi', 'Có lỗi xảy ra vui lòng thử lại sau!', {
                        position: 'topRight'
                    });
                }
            })
        });
    </script>
@endsection
