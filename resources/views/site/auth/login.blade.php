@extends('site.auth.layout.main')
@section('content')
    <div class="container px-3 px-sm-5 px-md-0 px-lg-3 py-2 w-100 h-auto justify-content-center align-self-center">
        <div class="row mx-auto px-lg-5 py-2 m-0">
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/auth_bg.svg') }}" class="img-fluid object-fit-contain h-100" alt="bg-image" />
            </div>
            <div class="col-12 col-md-6 ps-lg-4">
                <form class="form-control border-0" method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="col-12">
                        <div class="d-flex justify-content-center mb-3">
                            <a href="{{ route('home') }}">
                                <img class="img-fluid object-fit-contain logo-image" alt="logo" src="{{ asset(setting('site.logo')) }}" />
                            </a>
                        </div>
                    </div>
                    <h3 class="text-primary app-headline-3 text-center">{{ __('auth.login') }}</h3>
                    <p class="text-center my-4">{{ __('auth.login_intro') }}</p>
                    @error('auth_failed')
                        <span class="text-danger app-caption-text">{{ $message }}</span>
                    @enderror
                    <div class="pt-3 pb-2">
                        <p class="mb-2">{{ __('auth.phone_or_email') }}<span class="text-danger">*</span></p>
                        <input autofocus value="{{ old('username') }}" name="username" type="text"
                            class="form-control shadow-none border-1 border-black p-2 fw-light"
                            placeholder="{{ __('auth.enter_phone_or_email') }}" />
                        @error('username')
                            <span class="text-danger app-caption-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{ __('auth.password') }}<span class="text-danger">*</span></p>
                        <input type="password" name="password"
                            class="form-control shadow-none border-1 border-black py-2 fw-light"
                            placeholder="{{ __('auth.enter_password') }}" />
                        @error('password')
                            <span class="text-danger app-caption-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="app-body-text-2">
                            <input type="checkbox" name="remember_account"
                                class="form-check-input shadow-none border-black" />
                            <span class="ms-1 fw-light fs-6">{{ __('auth.remember_account') }}</span>
                        </label>
                        <a href="{{ route('auth.forgot_password.form') }}"
                            class="text-primary app-subtitle-2 text-decoration-none fs-6">{{ __('auth.forgot_password') }}</a>
                    </div>
                    <button type="submit"
                        class="btn btn-primary shadow-lg border-0 w-100 py-2 text-uppercase">{{ __('auth.login') }}
                    </button>
                    <p class="app-subtitle-2 my-3 text-center fw-light">{{ __('auth.do_not_have_account') }} <a
                            href="{{ route('auth.register.form') }}"
                            class="text-primary text-decoration-none">{{ __('auth.register_now') }}</a></p>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        @if (Session::has('message'))
            showToast('success', 'Thông báo', '{{ Session::get('message')['content'] }}', {
                position: 'topRight'
            })
        @endif
    </script>
@endsection
