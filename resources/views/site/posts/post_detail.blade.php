@extends('site.layouts.main')
@section('title')
    {{ $post->title }}
@endsection
@section('css')
    <link rel='stylesheet' href='{{ asset('css/post.css') }}' />
@endsection
@section('content')
    @php
        $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
        $user = Auth::user();
        $author = $post->author;
        $isDifferentAuthor = Auth::id() !== $author->id;
        $isPartner = $author->role_id == config('constants.ROLES')['PARTNER'];
        $isSold = $post->post_state == config('constants.POST_STATUS')['SOLD'];
    @endphp
    <div class="container-fluid bg-secondary py-3 content-bounce-margin my-md-0">
        <div class="container p-0 mx-auto">
            <div class="row">
                <div class="col-12 col-lg-8 px-0 order-1 order-lg-0">
                    <div class="bg-white p-3 mx-3">
                        <div id="post-images" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @for ($i = 0; $i < count($post->images); $i++)
                                    <div class="post-slide-container carousel-item {{ $i === 0 ? 'active' : '' }}"
                                        data-bs-interval="3500">
                                        <img src="{{ asset($post->images[$i]->path) }}"
                                            class="d-block w-100 h-100 object-fit-contain"
                                            alt="{{ $post->images[$i]->alt }}">
                                    </div>
                                @endfor
                            </div>
                            <button class="carousel-control-prev z-0" type="button" data-bs-target="#post-images"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next z-0" type="button" data-bs-target="#post-images"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="justify-content-start my-2 d-none d-md-flex">
                            @for ($i = 0; $i < count($post->images); $i++)
                                <div class="post-img-preview mx-2 {{ $i === 0 ? 'active' : '' }}"
                                    data-slide-to="{{ $i }}">
                                    <img src="{{ asset($post->images[$i]->path) }}" class="img-fluid"
                                        alt="{{ $post->images[$i]->alt }}">
                                </div>
                            @endfor
                        </div>
                        <h1 class="my-2 fs-4 fw-regular text-break">{{ $post->title }}</h1>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="fs-5 fw-regular">{{ __('post_detail.price') }}:
                                <span class="text-danger fw-medium">
                                    {{ number_format($post->price, 0, '', '.') }}{{ __('wallet.vnd') }}
                                </span>
                            </h2>
                            @if ($user)
                                <button data-save-post-id="{{ $post->id }}"
                                    class="btn border-0 toggle-save-button subtitle">
                                    @if ($isSavedPost)
                                        <img src="{{ asset('images/heart-fill.svg') }}" /></a>
                                        <span class="text-danger fw-light subtitle save-post-text">
                                            {{ __('post_detail.saved_post') }}
                                        </span>
                                    @else
                                        <img src="{{ asset('images/heart.svg') }}" /></a>
                                        <span class="text-danger fw-light subtitle save-post-text">
                                            {{ __('post_detail.save_post') }}
                                        </span>
                                    @endif
                                </button>
                            @else
                                <a href="{{ route('auth.login') }}" class="btn border-0 subtitle">
                                    <img src="{{ asset('images/heart.svg') }}" />
                                    <span class="text-danger fw-light subtitle">
                                        {{ __('post_detail.save_post') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                        <h3 class="subtitle my-1">{{ __('post_detail.support_limit') }}
                            <span class="text-primary">{{ number_format($post->support_limit, 0, '', '.') }}
                                {{ __('wallet.vnd') }}</span>
                        </h3>
                        <h3 class="subtitle my-1">{{ __('post_detail.support_receive') }}<span
                                class="text-primary">{{ number_format($post->receive_support, 0, '', '.') }}
                                {{ __('wallet.vnd') }}/{{ __('post_detail.day') }}</span>
                        </h3>
                        <h3 class="subtitle my-1">{{ __('post_detail.support_time') }}<span
                                class="text-primary">{{ $post->expire_limit_month }}{{ __('post_detail.month') }}</span>
                        </h3>
                        @if (count($post->author->fullAddresses($post->author->id)) > 0)
                            <div class="d-flex mt-2">
                                <img src="{{ asset('images/location.svg') }}" class="object-fit-contain">
                                <p class="subtitle mx-3 my-0 fw-light">
                                    {{ $post->author->fullAddresses($post->author->id)[0] }}
                                </p>
                            </div>
                        @endif
                        <div class="d-flex align-items-center my-2">
                            <img class="object-fit-contain" src="{{ asset('images/cloud-upload.svg') }}" />
                            <p class="subtitle mx-3 my-0 fw-light">
                                {{ __('post_detail.push') }}
                                {{ \Carbon\Carbon::parse($post->release_date)->diffForHumans(\Carbon\Carbon::now()) }}</p>
                        </div>
                        <div class="d-flex align-items-center my-1">
                            <img class="object-fit-contain" src="{{ asset('images/shield-check.svg') }}" />
                            <p class="subtitle fw-light mx-3 my-0">{{ __('post_detail.post_verified') }}</p>
                        </div>
                    </div>
                    @if ($post->addition_info)
                        <div class="bg-white p-3 my-3 mx-3">
                            <h5 class="fs-6">{{ __('post_detail.addition_info') }}</h5>
                            <div class="py-2 text-break">
                                {!! preg_replace($scriptTagRegex, '', html_entity_decode($post->addition_info)) !!}
                            </div>
                        </div>
                    @endif
                    <div class="bg-white p-3 my-3 mx-3">
                        <h5 class="fs-6">{{ __('post_detail.description') }}</h5>
                        <div class="py-2 post-description text-break">
                            {!! preg_replace($scriptTagRegex, '', html_entity_decode($post->description)) !!}
                        </div>
                    </div>
                    <div class="bg-white p-3 my-3 mx-3 d-lg-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($post->author->avatar) }}" class="avatar-post-detail"
                                    alt="avatar user" />
                                <span class="ms-1 fs-6 subtitle fw-medium">
                                    @if ($isPartner)
                                        <div class="d-inline-flex">
                                            <button
                                                class="provider-bg border-0 text-white rounded-1 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('images/provider.svg') }}" class="object-fit-cover"
                                                    alt="provider-image" />
                                                <span
                                                    class="ms-1 overline fw-light">{{ __('post_detail.provider') }}</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{ $post->author->name }}
                                </span>
                            </div>
                            <a href="{{ route('user.info', $post->author->referral_code) }}"
                                class="btn btn-outline-primary text-nowrap fw-light p-1"
                                style="font-size: 12px;">{{ __('post_detail.view_page') }}</a>
                        </div>
                        <div class="d-flex justify-content-start align-items-center">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <span class="text-warning subtitle mx-1">5.0</span>
                        </div>
                        <div class="d-flex justify-content-start align-items-center my-3">
                            <p class="subtitle fw-light neutral-300 my-0">{{ $post->author->posts()->count() }}
                                {{ __('post_detail.post') }}</p>
                            <p class="subtitle fw-light neutral-300 mx-4 my-0">{{ __('post_detail.member_from') }}
                                {{ \Carbon\Carbon::parse($post->author->created_at)->year }}</p>
                        </div>
                        @if ($isDifferentAuthor)
                            <a type="button" {!! $user ? 'data-bs-toggle="modal" data-bs-target="#choose_payment_method"' : 'href=' . route('auth.login') !!}
                                class="btn btn-outline-primary w-100 p-1 {{ $isSold ? 'disabled' : '' }}">
                                <span class="subtitle">
                                    {{ $isSold ? __('post_detail.sold') : __('post_detail.buy_now') }}
                                </span>
                            </a>
                        @endif
                        <div class="d-flex mt-2">
                            <a href="tel:{{ $post->author->phone }}"
                                class="btn btn-outline-primary p-1 subtitle me-1 {{ $isDifferentAuthor ? 'w-50' : 'w-100' }}">
                                <i class="fa-solid fa-phone me-1"></i>
                                <span class="subtitle">{{ $post->author->phone }}</span>
                            </a>
                            @if ($isDifferentAuthor)
                                <a href="{{ route('chat', ['receiver_id' => $post->author->id, 'post_id' => $post->id]) }}"
                                    class="w-50 btn btn-primary p-1 border-0">
                                    <i class="fa-solid fa-comments"></i>
                                    <span class="subtitle">{{ __('post_detail.chat') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white p-3 my-3 mx-3 d-none">
                        <div class="fx-h5 fw-regular">Tags</div>
                        <div class="d-flex align-items-center justify-content-start">
                            @foreach ($post->tags as $tag)
                                <h3 class="fs-6 fw-light">
                                    <a class="nav-link bg-warning text-white py-1 px-2 rounded mx-1 my-1"
                                        href="{{ route('site.search', ['search_query' => $tag->name]) }}">{{ $tag->name }}</a>
                                </h3>
                            @endforeach
                        </div>
                        @if (count($post->tags) <= 0)
                            <h6 class="text-center fw-light">{{ __('message.no_tag_post') }}</h6>
                        @endif
                    </div>
                    <div class="bg-white p-3 my-3 mx-3">
                        <h5 class="fs-6 fw-bold">{{ __('post_detail.share_with_friends') }}</h5>
                        <div class="flex-column">
                            <button id="facebook-share-btn" class="btn border-0 p-0">
                                <img src={{ asset('images/facebook-icon.svg') }}>
                            </button>
                            <span id="current-post-url" class="d-none">{{ url()->current() }}</span>
                            <button class="btn border-0 p-0" onclick="copyText('#current-post-url')">
                                <img src={{ asset('images/link-icon.svg') }}>
                            </button>
                        </div>
                    </div>
                    <div class="bg-white p-3 my-3 mx-3">
                        <h5 class="fs-6">{{ __('post_detail.related_post') }}</h5>
                        <div class="row my-2">
                            @if (count($related_posts) <= 0)
                                <h6 class="text-center fw-light">
                                    {{ __('message.no_related_post') }}</h6>
                            @endif
                            @foreach ($related_posts as $post_related)
                                <x-site.post-item-for-gird type="gird" :post="$post_related" mb="6" md="4"
                                    price="show" support='show' providerTop="show" address="show" time="show"
                                    lg="4"></x-site.post-item-for-gird>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 px-0 d-none d-lg-block">
                    <div class="p-3 bg-white mx-3 mx-lg-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($post->author->avatar) }}" class="avatar-post-detail"
                                    alt="avatar user" />
                                <span class="ms-1 fs-6 subtitle fw-medium">
                                    @if ($isPartner)
                                        <div class="d-inline-flex">
                                            <button
                                                class="provider-bg border-0 text-white rounded-1 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('images/provider.svg') }}" class="object-fit-cover"
                                                    alt="provider-image" />
                                                <span
                                                    class="ms-1 overline fw-light">{{ __('post_detail.provider') }}</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{ $post->author->name }}
                                </span>
                            </div>
                            <a href="{{ route('user.info', $post->author->referral_code) }}"
                                class="btn btn-outline-primary fw-light p-1 text-nowrap"
                                style="font-size: 12px;">{{ __('post_detail.view_page') }}</a>
                        </div>
                        <p class="subtitle my-2">{{ $post->author->fullAddresses($post->author->id)[0] ?? '' }}</p>
                        <div class="d-flex justify-content-start align-items-center my-3">
                            <p class="subtitle fw-light neutral-300 my-0">{{ $post->author->posts()->count() }}
                                {{ __('post_detail.post') }}</p>
                            <p class="subtitle fw-light neutral-300 mx-4 my-0">{{ __('post_detail.member_from') }}
                                {{ \Carbon\Carbon::parse($post->author->created_at)->year }}</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-5">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <img src="{{ asset('images/star.svg') }}" class="object-fit-contain me-1">
                            <span class="text-warning subtitle mx-1">5.0</span>
                        </div>
                        @if ($isDifferentAuthor)
                            <a type="button" {!! $user ? 'data-bs-toggle="modal" data-bs-target="#choose_payment_method"' : 'href=' . route('auth.login') !!}
                                class="btn btn-outline-primary w-100 py-2 {{ $isSold ? 'disabled' : '' }}">
                                <span class="subtitle"> {{ $isSold ? __('post_detail.sold') : __('post_detail.buy_now') }}</span>
                            </a>
                        @endif
                        <a href="tel:{{ $post->author->phone }}" class="btn btn-outline-primary w-100 py-2 mt-2">
                            <i class="fa-solid fa-phone me-1"></i>
                            <span class="subtitle">{{ $post->author->phone }}</span></a>
                        @if ($isDifferentAuthor)
                            <a href="{{ route('chat', ['receiver_id' => $post->author->id, 'post_id' => $post->id]) }}">
                                <button class="btn btn-primary w-100 py-2 mt-2">
                                    <i class="fa-solid fa-comments me-1"></i>
                                    <span>{{ __('post_detail.chat_with_seller') }}</span>
                                </button>
                            </a>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 d-none">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/support_msg.svg') }}" class="object-fit-contain me-1">
                            <a class="subtitle fw-light ms-2 nav-link">{{ __('post_detail.need_help') }}</a>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/report_chat.svg') }}" class="object-fit-contain me-1">
                            <a class="subtitle fw-light ms-2 nav-link">{{ __('post_detail.report_this_post') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('site.order_modal.choose_payment_method')
    @include('site.order_modal.success_order')
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            const currentUrl = window.location.href;
            const urlSchemeFb = '{{ config('constants.URL_SCHEME_SHARE.FACEBOOK') }}';

            $("#facebook-share-btn").on("click", function() {
                const fbShareUrl = urlSchemeFb + encodeURIComponent(currentUrl);
                window.open(fbShareUrl, "_blank");
            });
        });

        $(document).ready(function() {
            let carousel = $('#post-images');
            carousel.on('slid.bs.carousel', function(event) {
                let currentIndex = carousel.find('.carousel-item.active').index();
                $('.post-img-preview').removeClass('active');
                $('.post-img-preview[data-slide-to="' + currentIndex + '"]').addClass('active');
            });
            $('.post-img-preview').on('click', function() {
                let slideIndex = $(this).data('slide-to');
                carousel.carousel(slideIndex);
            });
        });

        $(document).ready(function() {
            const saveButton = $('.toggle-save-button');

            saveButton.click(async function() {
                const postId = $(this).data('save-post-id');
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
                            saveButton.find('img').attr('src', '{{ asset('images/heart-fill.svg') }}');
                            saveButton.find('.save-post-text').text(
                                '{{ __('post_detail.saved_post') }}');
                        } else {
                            saveButton.find('img').attr('src', '{{ asset('images/heart.svg') }}');
                            saveButton.find('.save-post-text').text(
                                '{{ __('post_detail.save_post') }}');
                        }
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
            });
        });

        $(document).ready(function() {
            const paymentCodButton = $('#payment-cod-btn');

            paymentCodButton.click(async function() {
                const postId = $(this).data('payment-cod-post-id');

                try {
                    const response = await fetch(`{{ route('api.order.create') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'apiKey': authToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            postId
                        })
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        showToast('error', 'Lỗi', error.message, {
                            position: 'topRight'
                        });
                    } else {
                        const data = await response.json();
                        $('#success_order_modal').modal('show');
                        showToast('success', 'Thông báo', data.message, {
                            position: 'topRight'
                        });
                    }
                } catch (error) {
                    showToast('error', 'Lỗi', 'Có lỗi xảy ra vui lòng thử lại sau!', {
                        position: 'topRight'
                    });
                }
            });
        });
    </script>
@endsection
