@extends('site.auth.layout.main')
@section('content')
    <div class="container px-3 px-sm-5 px-md-0 px-lg-3 py-3 w-100 h-auto justify-content-center align-self-center">
        <div class="row w-100 px-lg-5 py-3 m-0">
            <div class="col-md-6 col-lg-6 d-none d-md-block">
                <img src="{{ asset('images/auth_bg.svg') }}" class="img-fluid object-fit-contain h-100" alt="bg-image"/>
            </div>
            <div class="col-12 col-md-6 col-lg-6 ps-lg-5">
                <form class="form-control border-0" method="POST" action="{{route('auth.register')}}">
                    @csrf
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-2 mb-3">
                            <a href="{{ route('home') }}">
                                <img class="img-fluid object-fit-contain logo-image" alt="logo" src="{{ asset(setting('site.logo')) }}" />
                            </a>
                        </div>
                    </div>
                    <h3 class="text-primary app-headline-3 text-center">{{__('auth.register')}}</h3>
                    <p class="text-center my-4">{{__('auth.reg_intro')}}</p>
                    @error('auth_failed')
                    <span class="text-danger caption">{{ $message }}</span>
                    @enderror
                    <div class="pt-3 pb-2">
                        <p class="mb-2">{{__('auth.full_name')}}<span class="text-danger">*</span></p>
                        <input value="{{ old('name') }}" required autofocus name="name" type="text"
                               class="form-control shadow-none border-1 border-black fw-light p-2"
                               placeholder="{{__('auth.enter_full_name')}}"/>
                        @error('name')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{__('auth.phone')}}<span class="text-danger">*</span></p>
                        <input value="{{ old('phone') }}" required name="phone" type="tel"
                               class="form-control shadow-none border-1 border-black fw-light p-2"
                               placeholder="{{__('auth.enter_phone')}}"/>
                        @error('phone')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{__('auth.email')}}<span class="text-danger">*</span></p>
                        <input value="{{ old('email') }}" required name="email" type="email"
                               class="form-control shadow-none border-1 border-black fw-light p-2"
                               placeholder="{{__('auth.enter_email')}}"/>
                        @error('email')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{__('auth.password')}}<span class="text-danger">*</span></p>
                        <input required type="password" name="password"
                               class="form-control shadow-none border-1 border-black fw-light py-2"
                               placeholder="{{__('auth.enter_password')}}"/>
                        @error('password')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{__('auth.confirm_password')}}<span class="text-danger">*</span></p>
                        <input required type="password" name="password_confirmation"
                               class="form-control shadow-none border-1 border-black fw-light  py-2"
                               placeholder="{{__('auth.enter_confirm_password')}}"/>
                        @error('password_confirmation')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-2">
                        <p class="mb-2">{{__('user_info.referral_code')}}</p>
                        <input value="{{ old('referral_code') }}" type="text" name="referral_code"
                               class="form-control shadow-none border-1 border-black fw-light py-2"
                               placeholder="{{__('user_info.referral_code')}}"/>
                        @error('referral_code')
                        <span class="text-danger caption">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="app-body-text-2 my-2 d-flex justify-content-between">
                        <input required type="checkbox" name="accept_police" class="form-check-input p-2 shadow-none"/>
                        <span class="ms-1 fw-light">
                            {!! html_entity_decode(__('auth.deal',['terms'=>__('auth.terms_html',['term'=>__('auth.term')]),'usages'=>__('auth.usages_html',['usage'=>__('auth.usage')])]))!!}
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 shadow-lg border-0 w-100 py-2 text-uppercase">
                        {{__('auth.register')}}
                    </button>
                    <p class="app-subtitle-2 my-3 text-center">
                        {{__('auth.have_an_account')}}
                        <a href="{{ route('auth.login.form') }}"
                           class="text-primary text-decoration-none">{{__('auth.login_now')}}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
