@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 mx-auto content-bounce-margin d-flex justify-content-center align-self-center">
            <div class="col-12 row mx-1">
                <div class="card rounded-0 border-0">
                    <h5 class="fs-5 my-3 mx-2">{{ __('user_info.saved_posts') }}</h5>
                    <div class="card-body text-center">
                        <p class="mb-0 subtitle fs-6">{{ __('user_info.no_saved_posts') }}</p>
                        <p class="mt-0 subtitle fs-6">{!! __('user_info.msg_saved_posts', ['icon' => '<i class="fa-regular fa-heart text-danger"></i>']) !!}</p>
                        <a href="{{ route('home') }}"
                            class="btn btn-txt btn-primary border-0 text-white my-1">{{ __('chat.go_to_home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
