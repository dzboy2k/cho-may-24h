@extends('site.auth.layout.main')
@section('content')
    <div class="container px-3 px-sm-5 px-md-0 px-lg-3 py-5 w-100 h-auto justify-content-center align-self-center">
        <div class="row w-100 px-lg-5 py-5 m-0">
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/auth_bg.svg') }}" class="img-fluid object-fit-cover h-100" alt="bg-image"/>
            </div>
            <div class="col-12 col-md-6 px-lg-5">
                <form class="form-control border-0" method="POST" action="{{route('auth.forgot_password')}}">
                    @csrf
                    <h3 class="text-primary app-headline-3 text-center">{{__('auth.forgot_password')}}</h3>
                    <p class="text-center my-4">{{__('auth.forgot_password_intro')}}</p>
                    <div class="pt-3 pb-2">
                        <p class="mb-2">{{__('auth.email')}}<span class="text-danger">*</span></p>
                        <input autofocus value="{{ old('email') }}" name="email" type="text"
                               class="form-control shadow-none border-1 border-black p-2 fw-light"
                               placeholder="{{__('auth.email_enter')}}"/>
                        @error('email')
                        <span class="text-danger app-caption-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                            class="btn btn-primary shadow-lg border-0 w-100 py-2 text-uppercase mt-5">{{__('auth.send_request')}}
                    </button>
                    <a class="nav-link d-block text-center mt-3 text-decoration-underline" href="{{route('auth.login.form')}}">{{__('auth.back_login')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        @if (Session::has('message'))
        showToast('{{Session::get('message')['type']}}', 'Thông báo', '{{ Session::get('message')['content'] }}', {
            position: 'topRight'
        })
        @endif
    </script>
@endsection
