@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-4 col-xl-4 col-md-6 col-lg-4 p-2 d-none d-md-block d-md-flex row remove-line-breaks my-auto">
                <span class="h6">{{ __('withdrawal.content.title_transaction') }}</span>
                <span class="btn-txt">{{ __('withdrawal.content.tagline_transaction') }}</span>
                <img src="{{ asset('images/transaction.svg') }}" class="img-fluid object-fit-cover w-100"
                    alt="image transaction" />
            </div>
            <div class="col-12 col-xl-4 col-md-6 col-lg-4 my-auto">
                <div
                    class="p-lg-3 mx-1 px-1 border border-black bg-white d-flex row justify-content-center align-items-center">
                    <img src="{{ asset('images/confirmation.svg') }}" class="img-fluid object-fit-cover w-30"
                        alt="transaction successful" />
                    <div class="text-center py-2">
                        <span class="subtitle font-weight-bol">{{ __('withdrawal.content.confirmed_request') }}</span>
                        <span class="subtitle font-weight-bol">{{ __('withdrawal.content.desc_respond') }}</span>
                    </div>
                    <a href="{{ route('home') }}"
                        class="btn btn-txt btn-primary shadow-lg border-0 w-100 py-2 my-3 app-button-text text-uppercase">
                        {{ __('withdrawal.title.back_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
