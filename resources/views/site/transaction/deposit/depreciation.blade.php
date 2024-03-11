@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-12 col-md-6 col-lg-4 p-3 bg-white">
                <div class="title">
                    <h5>{{ __('deposit.transfer_depreciation') }}</h5>
                </div>
                <small class="text-primary">{{ __('deposit.depre_wallet') }}
                    : {{ number_format(Auth::user()->wallet->get_depreciation_support, 0, ',', '.') }}
                    {{ __('wallet.vnd') }}</small>
                <form action="{{ route('deposit.transaction.transfer_coin_from_get_depreciation_to_the_main_wallet.create') }}" method="POST">
                    @csrf
                    <div class="py-4">
                        <h6 class="subtitle">{{ __('deposit.fund_depre_wallet') }}</h6>
                        <input id="depreciation" class="form-control subtitle app-body-text-2 py-2"
                            placeholder="{{ __('deposit.enter_amount') }}" />
                        <input type="text" id="fluctuation" name="fluctuation"
                            class="form-control subtitle app-body-text-2 py-2 hide"
                            placeholder="{{ __('deposit.enter_amount') }}" />
                    </div>
                    <h6 class="subtitle">{{ __('deposit.fund_payment_wallet') }}</h6>
                    <b class="subtitle text-break" id="receive">0 {{ __('wallet.dm') }}</b>
                    <button type="submit"
                        class="btn btn-primary shadow-lg border-0 w-100 py-2 my-2 app-button-text text-uppercase">
                        {{ __('deposit.continue') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const amountInput = document.getElementById('depreciation');
        const fluctuationInput = document.getElementById('fluctuation');
        const receiveText = document.getElementById('receive');
        new Cleave('#depreciation', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            onValueChanged: function(e) {
                fluctuationInput.value = e.target.rawValue;
                receiveText.textContent = e.target.value + ' {{ __('wallet.dm') }}'
            }
        });
    </script>
@endsection
