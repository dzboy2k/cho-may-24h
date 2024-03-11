@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}'/>
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-between my-3">
                    <div class="col-12 d-flex d-md-block justify-content-center">
                        <h5 class="mb-3">{{ __('history.menbership') }}</h5>
                        <h5 class="text-success fw-bold">
                            {{ number_format(Auth::user()->wallet->membership_point, 0, '.', '.') }}
                            {{ __('wallet.point') }}
                        </h5>
                    </div>
                </div>
                @include('site.history.partials.transactions_render')
            </div>
        </div>
    </div>
@endsection
