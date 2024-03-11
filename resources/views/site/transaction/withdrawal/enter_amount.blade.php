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
                <div class="p-lg-3 border border-black bg-white">
                    <form class="form-control border-0 bg-white" method="POST" action="{{route('withdrawal.handle')}}">
                        @csrf
                        <div class="title">
                            <h5>{{ __('withdrawal.title.withdrawal') }}</h5>
                        </div>
                        <div class="pt-3">
                            <span class="subtitle text-muted">{{ __('withdrawal.title.withdrawal_amount') }}</span>
                            <div class="border border-black d-flex rounded px-2">
                                <input value="" name="withdrawal_amount" type="number"
                                    class="form-control subtitle p-2 border-0 shadow-none enter_withdrawal_amount"
                                    placeholder="{{ __('withdrawal.title.enter_withdrawal_amount') }}" />
                                <span class="bg-primary p-2 border rounded-circle m-auto text-warning"></span>
                                <span class="m-auto px-1"> {{ __('wallet.dm')}} </span>
                            </div>
                        </div>
                        <div class="pt-3 pb-3">
                            <span class="subtitle text-muted">{{ __('withdrawal.title.amount_received') }}</span>
                            <div class="border border-black d-flex rounded px-2">
                                <input class="form-control subtitle p-2 border border-0 shadow-none withdrawal-amount-received" readonly
                                    placeholder="0" />
                                <span class="bg-danger caption px-1 border rounded-circle m-auto text-warning subtitle">{{ __('wallet.vnd') }}
                                </span>
                                <span class="m-auto px-1">{{ __('wallet.vnd')}}</span>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-txt btn-primary shadow-lg border-0 w-100 py-2 my-3 app-button-text text-uppercase">
                            {{ __('withdrawal.title.continue') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        copyInputValue('.enter_withdrawal_amount', '.withdrawal-amount-received');
    </script>
@endsection
