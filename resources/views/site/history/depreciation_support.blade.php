@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}' />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-between align-items-center my-3">
                    <div class="col-12 col-md-5 align-center-mobile">
                        <h5 class="mb-2">{{ __('history.get_depreciation') }}</h5>
                        <h5 class="text-success fw-bold">
                            {{ number_format(Auth::user()->wallet->get_depreciation_support, 0, '.', '.') }}
                            {{ __('wallet.vnd') }}
                        </h5>
                    </div>
                    <div class="col-12 col-md-7 my-md-auto d-md-flex align-items-center justify-content-center my-2 align-center-mobile">
                        <a href="{{ route('deposit.method') }}"
                            class="me-2 btn btn-primary shadow-lg rounded border-0 px-5 py-2 btn-txt ">
                            {{ __('history.deposit_dm') }}
                        </a>
                        <a href="{{ route('withdrawal.bank.account') }}"
                            class="btn btn-warning shadow-lg rounded border-0 px-5 py-2 subtitle text-white text-center">
                            {{ __('history.withdraw') }}
                        </a>
                    </div>
                </div>
                @include('site.history.partials.transactions_render')
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
