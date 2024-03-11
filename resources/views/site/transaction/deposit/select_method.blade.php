@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-4 col-xl-4 col-md-6 col-lg-4 p-3 d-none d-md-block">
                <span class="h6">{{ __('deposit.title_deposit') }}</span>
                <p class="btn-txt">{{ __('deposit.note_title_deposit') }}</p>
                <img src="{{ asset('images/transaction.svg') }}" class="img-fluid object-fit-cover w-100" alt="bg-image" />
            </div>
            <div class="col-12 col-xl-4 col-md-6 col-lg-4 my-auto ">
                <div class="p-2 p-lg-3 border border-dark bg-white">
                    <div class="title">
                        <span class="h5">{{ __('deposit.deposit') }}</span>
                    </div>
                    <p class="subtitle text-dark ">{{ __('deposit.deposit_method') }}</p>
                    <a href="{{ route('deposit.amount', ['type' => config('constants.DEPOSIT_TYPES')['TRADITIONAL']]) }}">
                        <button type="submit"
                            class="btn btn-txt btn-primary shadow-lg border-0 w-100 py-2 my-2 app-button-text text-uppercase">
                            {{ __('deposit.method_1') }}
                        </button>
                    </a>
                    <a href="{{ route('deposit.depreciation.transfer') }}">
                        <button type="submit"
                            class="btn btn-txt btn-warning shadow-lg border-0 w-100 py-2 my-2 app-button-text text-uppercase text-white">
                            {{ __('deposit.method_2') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
