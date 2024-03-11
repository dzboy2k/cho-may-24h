@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container-fluid bg-secondary py-3 my-md-0">
            <div
                class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
                <div class="col-xl-4 col-12 col-md-4 col-lg-4 p-3 d-none d-md-block">
                    <span class="h6">{{ __('deposit.title_deposit') }}</span>
                    <p class="btn-txt">{{ __('deposit.note_title_deposit') }}</p>
                    <img src="{{ asset('images/transaction.svg') }}" class="img-fluid object-fit-cover w-100" alt="bg-image" />
                </div>
                <div class="col-xl-4 col-12 col-md-4 col-lg-4 my-auto bg-white p-3 border border-dark ">
                    <div class=" p-1">
                        <span class="fw-bolder">{{ __('deposit.bank_name') }}</span>
                        <p class="subtitle text-muted">{{ setting('site.bank_name') }}</p>
                    </div>
                    <div class=" p-1">
                        <span class="fw-bolder">{{ __('deposit.account_number') }}</span>
                        <p class="subtitle text-muted">{{ setting('site.bank_account_id_of_casso') }}</p>
                    </div>
                    <div class=" p-1">
                        <span class="fw-bolder">{{ __('deposit.account_owner') }}</span>
                        <p class="subtitle text-muted">{{ setting('site.bank_owner') }}</p>
                    </div>
                    <div class=" p-1">
                        <span class="fw-bolder">{{ __('deposit.branch') }}</span>
                        <p class="subtitle text-muted">{{ setting('site.bank_branch') }}</p>
                    </div>
                    <div class=" p-1">
                        <span class="fw-bolder">{{ __('deposit.money_transfer') }}</span>
                        <p class="subtitle text-danger">{{ number_format($transaction->fluctuation, 0, ',', '.') }}
                            {{ __('wallet.vnd') }}</p>
                    </div>
                    <div class="p-1">
                        <span class="fw-bolder">{{ __('deposit.note_transfer') }}</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="subtitle text-muted my-0" id="transaction-code">{{ $transaction->id }}</p>
                            <a class="btn btn-link subtitle text-warning text-decoration-none"
                                onclick="copyText('#transaction-code')">{{ __('user_info.copy') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
