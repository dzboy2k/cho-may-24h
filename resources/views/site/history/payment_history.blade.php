@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}' />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-between my-3">
                    <div class="col-12 col-md-6 align-center-mobile">
                        <h5 class="mb-3">{{ __('history.payment_wallet') }}</h5>
                        <h5 class="text-success fw-bold">
                            {{ number_format(Auth::user()->wallet->payment_coin, 0, '.', '.') }}
                            {{ __('wallet.dm') }}
                        </h5>
                    </div>
                    <div class="col-12 col-md-6 my-md-auto d-md-flex my-2 justify-content-end align-center-mobile">
                        <a href="{{ route('deposit.method') }}"
                            class="me-2 btn btn-primary shadow-lg rounded border-0 px-5 py-2 btn-txt ">
                            {{ __('history.deposit_dm') }}
                        </a>
                    </div>
                </div>
                @include('site.history.partials.transactions_render')
            </div>
        </div>
    </div>
@endsection
