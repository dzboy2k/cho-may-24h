@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}' />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-between my-3">
                    <div class="col-12 col-md-5 align-center-mobile">
                        <h5 class="mb-3">{{ __('history.sale_limit') }}</h5>
                        <h5 class="text-success fw-bold">
                            {{ number_format(Auth::user()->wallet->sale_limit, 0, '.', '.') }}
                            {{ __('wallet.vnd') }}
                        </h5>
                    </div>
                    <div class="col-12 col-md-7 my-md-auto d-md-flex my-2 justify-content-end align-center-mobile gap-2">
                        <a href="{{ route('deposit.to-sale-limit') }}"
                            class="my-2 my-md-0 btn btn-warning rounded border-0 px-5 py-2 btn-txt text-white">
                            {{ __('history.limit_increase') }}
                        </a>
                        <a href="{{ route('sale.limit.transfer.show') }}">
                            <button class="btn btn-primary rounded border-0 px-5 py-2 subtitle text-white text-center">
                                {{ __('transaction.transfer') }}
                            </button></a>
                    </div>
                </div>
                @include('site.history.partials.transactions_render')
            </div>
        </div>
    </div>
@endsection
