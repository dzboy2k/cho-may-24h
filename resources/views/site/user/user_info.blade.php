@extends('site.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
@endsection
@php
    $currentUser = Auth::check() ? Auth::user() : null;
    $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
    $showing = config('constants.SHOW_TYPES')['SHOWING'];
    $sold = config('constants.SHOW_TYPES')['SOLD'];
    $unverified = config('constants.SHOW_TYPES')['UNVERIFY'];
@endphp
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 mx-auto py-2 content-bounce-margin">
            <div class="row">
                <div class="col-lg-4 my-2">
                    <div class="card rounded-0 border-0">
                        <div class="card-header border-0 bg-white d-flex justify-content-center align-items-center">
                            <img class="card-img-top rounded-0 object-fit-contain img-fluid avatar-profile"
                                src="{{ asset($user->avatar) }}" alt="user avatar">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex mt-2">
                                <h5 class="mb-2">{{ $user->name }}</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="subtitle">{{ __('user_info.referral_code') }}:&nbsp;</span>
                                    <span id="refCode" class="subtitle">{{ $user->referral_code }}</span>
                                </div>
                                <a class="btn btn-link subtitle text-warning text-decoration-none"
                                    onclick="copyText('#refCode')">{{ __('user_info.copy') }}</a>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="subtitle">{{ __('user_info.followers') }}: {{ $user->amountFollowers }} </span>
                                <span class="subtitle">{{ __('user_info.followed') }}: {{ $user->amountFollowed }}</span>
                            </div>
                            <div class="container pb-4">
                                <div class="row">
                                    <div class="col-1 col-sm-1 px-0">
                                        <i class="fa-light fa-location-dot text-primary"></i>
                                    </div>
                                    <div class="col-10 col-sm-10 px-0">
                                        <span class="subtitle">
                                            {{ $user->addresses->isNotEmpty() ? $user->addresses->first()->full_address : __('user_info.no_address') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-1 col-sm-1 px-0">
                                        <i class="fa-light fa-phone text-primary"></i>
                                    </div>
                                    <div class="col-10 col-sm-10 px-0">
                                        <span class="subtitle">{{ $user->phone }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-1 col-sm-1 px-0">
                                        <i class="fa-light fa-calendar-days text-primary"></i>
                                    </div>
                                    <div class="col-10 col-sm-10 px-0">
                                        <span class="subtitle">{{ __('user_info.joined') }}
                                            {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans(\Carbon\Carbon::now()) }}</span>
                                    </div>
                                </div>
                            </div>
                            @if ($currentUser)
                                @php
                                    $isCurrentUser = $currentUser->id === $user->id;
                                @endphp
                                <a href="{{ $isCurrentUser ? route('profile.edit.form') : route('chat', ['receiver_id' => $user->id]) }}"
                                    class="btn btn-{{ $isCurrentUser ? 'outline-dark' : 'primary' }} w-100 text-uppercase btn-txt">
                                    <i class="fa-light {{ $isCurrentUser ? 'fa-user-pen' : 'fa-comments' }}"></i>
                                    {{ $isCurrentUser ? __('user_info.edit_profile') : __('user_info.chat_with_sellers') }}
                                </a>
                                @if ($isCurrentUser)
                                    <a href="{{ route('user.change_password.form') }}"
                                        class="btn btn-outline-dark w-100 text-uppercase btn-txt my-2">
                                        <i class="fa-light fa-lock"></i>
                                        {{ __('user_info.change_password') }}
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('user.follow', $user->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-{{ !$isFollowing ? 'warning text-white' : 'outline-dark' }} border-0 w-100 text-uppercase btn-txt mt-2">
                                            <i class="fa-solid fa-plus"></i>
                                            <span id="follow-button-label">
                                                {{ !$isFollowing ? __('user_info.follow') : __('user_info.unfollow') }}
                                            </span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('auth.login.form') }}"
                                    class="btn btn-primary border-0 w-100 text-uppercase btn-txt">
                                    <i class="fa-light fa-share-nodes"></i>
                                    {{ __('user_info.chat_with_sellers') }}
                                </a>
                                <a href="{{ route('auth.login.form') }}"
                                    class="btn btn-warning text-white border-0 w-100 text-uppercase btn-txt mt-2">
                                    <i class="fa-light fa-plus"></i>
                                    {{ __('user_info.follow') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 my-2">
                    <div class="card rounded-0 border-0">
                        <div class="card-header bg-white border-0">
                            <ul class="nav nav-tabs nav-tabs-flat justify-content-around border-0" role="tablist">
                                <li class="nav-item {{ @$type == $showing ? 'active' : '' }}" role="presentation">
                                    <a class="nav-link text-black border-0 "
                                        href="{{ route('user.info', ['id' => $user->referral_code, 'showType' => $showing]) }}">
                                        {{ __('user_info.showing') }}
                                    </a>
                                </li>
                                @if ($currentUser && $currentUser->id == @$user->id)
                                    <li class="nav-item {{ @$type == $sold ? 'active' : '' }}" role="presentation">
                                        <a class="nav-link text-black border-0"
                                            href="{{ route('user.info', ['id' => $currentUser->referral_code, 'showType' => $sold]) }}">
                                            {{ __('user_info.sold') }}
                                        </a>
                                    </li>
                                    <li class="nav-item  {{ @$type == $unverified ? 'active' : '' }}" role="presentation">
                                        <a class="nav-link text-black border-0"
                                            href="{{ route('user.info', ['id' => $currentUser->referral_code, 'showType' => $unverified]) }}">
                                            {{ __('user_info.waiting_verify') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane fade show active" id="showing" role="tabpanel"
                                aria-labelledby="showing-tab">
                                <div class="px-2 row">
                                    @if (!$posts || $posts->isEmpty())
                                        @include('site.user.no_posts')
                                    @else
                                        @foreach ($posts as $post)
                                            @php
                                                $isVerified = $post->post_state == config('constants.POST_STATUS')['VERIFIED'];
                                            @endphp
                                            <div class="container py-2 border-bottom post-profile"
                                                data-profile-post-id="{{ $post->id }}">
                                                <div class="row">
                                                    <a href="{{ $isVerified ? route('post.detail', ['slug' => $post->slug]) : '#' }}"
                                                        class="col-md-10 text-decoration-none text-reset">
                                                        <div class="row">
                                                            <div
                                                                class="col-4 col-md-3 d-flex justify-content-center align-items-center">
                                                                @if ($image = $post->images->first())
                                                                    <img src="{{ asset($image->path) }}"
                                                                        alt="{{ $image->alt }}"
                                                                        class="object-fit-cover img-fluid post-image">
                                                                @endif
                                                            </div>
                                                            <div class="col-8 col-md-9 ps-1">
                                                                <div class="mb-1 row">
                                                                    <h5 class="fs-6 post-title-profile">{{ $post->title }}
                                                                    </h5>
                                                                    <p class="caption text-danger mb-0">
                                                                        <span class="text-black fw-light">
                                                                            {{ __('post_detail.price') }}:
                                                                        </span>
                                                                        {{ number_format($post->price, 0, '.', '.') }}
                                                                        {{ __('wallet.vnd') }}
                                                                    </p>
                                                                    <p class="caption text-primary mb-1">
                                                                        <span class="text-black fw-light">
                                                                            {{ __('user_info.depre_support_limit') }}
                                                                        </span>
                                                                        {{ number_format($post->support_limit, 0, '.', '.') }}
                                                                        {{ __('wallet.vnd') }}
                                                                    </p>
                                                                    <span class="caption fw-light">
                                                                        {{ __('user_info.posted') }}
                                                                        {{ \Carbon\Carbon::parse($post->release_date)->diffForHumans(\Carbon\Carbon::now()) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    @if ($currentUser)
                                                        @if ($isAuthorized && $is_sold != $post->post_state)
                                                            <div
                                                                class="col-md-2 col-12 d-flex justify-content-end align-items-center">
                                                                <div class="pe-0">
                                                                    <a href="{{ route('post.update.form', $post->id) }}"
                                                                        class="btn p-0 border-0 m-1" data-toggle="tooltip"
                                                                        title="{{ __('user_info.edit_post') }}">
                                                                        <img src="{{ asset('images/edit-icon.svg') }}"
                                                                            alt="" />
                                                                    </a>
                                                                    <a class="btn p-0 border-0 m-1 delete-post-btn"
                                                                        data-toggle="tooltip"
                                                                        title="{{ __('user_info.delete_post') }}">
                                                                        <img src="{{ asset('images/trash-delete.svg') }}"
                                                                            alt="" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center mt-2">
                                            {{ $posts->onEachSide(1)->links('site.components.pagination.pagination') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.delete-post-btn').on('click', function() {
                let postId = $(this).closest('.post-profile').data('profile-post-id');
                let deleteButton = this;

                if (confirm("{{ __('user_info.confirm_delete') }}")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('post.delete', ':id') }}'.replace(':id', postId),
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            $(deleteButton).closest('.post-profile').remove();
                            showToast('info', 'Thông báo', 'Xóa bài viết thành công!', {
                                position: 'topRight'
                            });
                            setTimeout(() => {
                                window.location.assign(window.location.href);
                            }, 2000)
                        },
                        error: function(error) {
                            showToast('error', 'Lỗi', 'Xóa bài viết không thành công!', {
                                position: 'topRight'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
