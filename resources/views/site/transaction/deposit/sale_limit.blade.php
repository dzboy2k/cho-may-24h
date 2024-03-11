@extends('site.layouts.main')
@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-12 col-md-6 col-lg-4 p-3 bg-white">
                <div class="title">
                    <h5>{{ __('history.limit_increase') }}</h5>
                </div>
                <small class="text-primary">{{ __('deposit.sale_limit') }}
                    : {{ number_format(@$user->wallet->sale_limit, 0, ',', '.') }}
                    {{__('wallet.vnd')}}</small>
                <form method="POST" action="{{route('deposit.to-sale-limit.transfer')}}">
                    @csrf
                    <div class="py-4">
                        <h6 class="subtitle">{{ __('deposit.coin_from_wallet') }}</h6>
                        <input value="0" id="sale-limit-amount"
                               class="form-control subtitle app-body-text-2 py-2 shadow-none"
                               placeholder="{{__('deposit.enter_amount')}}"/>
                        <input class="hide" name="amount" id="amount"/>
                    </div>
                    <h6 class="subtitle">{{ __('deposit.fund_to_sale_limit') }}</h6>
                    <b class="subtitle text-break" id="coin-transfer">0 {{__('wallet.vnd')}}</b>
                    <button type="submit"
                            class="btn btn-primary shadow-lg border-0 w-100 py-2 my-2 btn-texttext-uppercase">
                        {{ __('deposit.continue') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const coinTransfer = document.getElementById('coin-transfer');
        const enterInput = document.getElementById('sale-limit-amount');
        const amountInput = document.getElementById('amount');
        new Cleave('#sale-limit-amount', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            onValueChanged: function (e) {
                coinTransfer.textContent = formatCurrency(e.target.rawValue * {{setting('site.sale_limit_ratio')}})
                enterInput.value = e.target.value
                amountInput.value = e.target.rawValue
            }
        });
    </script>
@endsection
