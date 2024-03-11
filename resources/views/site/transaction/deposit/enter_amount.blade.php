@extends('site.layouts.main')
@section('content')
    @php
        $is_traditional = $type == config('constants.DEPOSIT_TYPES')['TRADITIONAL'];
    @endphp
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-4 col-xl-4 col-md-6 col-lg-4 p-3 d-none d-md-block">
                <h6>{{ __('deposit.title_deposit') }}</h6>
                <p class="btn-txt">{{ __('deposit.note_title_deposit') }}</p>
                <img src="{{ asset('images/transaction.svg') }}" class="img-fluid object-fit-cover w-100" alt="bg-image" />
            </div>
            <div class="col-12 col-xl-4 col-md-6 col-lg-4 my-auto ">
                <div class=" p-lg-3 border border-dark bg-white">
                    <form class="form-control border-0" method="POST" action="{{ route('deposit.transaction.create') }}">
                        @csrf
                        <div class="title">
                            <span class="h5">{{ __('deposit.deposit') }}</span>
                        </div>
                        <div class="pt-3">
                            <span class="subtitle">{{ __('deposit.deposit_money') }}</span>
                            <div class="border border-dark d-flex rounded">
                                <input required autofocus min="1" maxlength="14" id="deposit-amount"
                                    class="form-control subtitle app-body-text-2 p-2 border border-0 shadow-none"
                                    placeholder="Số tiền nạp vào" />
                                <input min="1" name="fluctuation" maxlength="14" id="fluctuation"
                                    class="form-control subtitle app-body-text-2 p-2 border border-0 shadow-none d-none"
                                    placeholder="Số tiền nạp vào" />
                                <span class="bg-danger caption px-1 border rounded-circle m-auto text-warning subtitle">
                                    {{ __('wallet.vnd') }}
                                </span>
                                <span class="m-auto px-1 text-uppercase">{{ __('wallet.vnd') }}</span>
                            </div>
                            @error('fluctuation')
                                <span class="text-danger caption px-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="pt-3 pb-2">
                            <span class="subtitle ">{{ __('deposit.receive_money') }}</span>
                            <div class="border border-dark d-flex rounded">
                                <input readonly value="0" id="amount-receive"
                                    class="form-control subtitle app-body-text-2 p-2 border border-0 shadow-none" />
                                <span class="bg-primary p-2 border rounded-circle m-auto text-warning"></span>
                                <span class=" m-auto px-1 text-uppercase">{{ __('wallet.dm') }}</span></p>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-primary shadow-lg border-0 w-100 py-2 my-3 app-button-text text-uppercase">
                            {{ __('deposit.continue') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const amountReceive = document.getElementById('amount-receive');
        const fluctuationInput = document.getElementById('fluctuation');
        const cf = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            maxlength: 10,
            onValueChanged: function(e) {
                amountReceive.value = e.target.value
                fluctuationInput.value = e.target.rawValue
            }
        }
        const amountInnut = new Cleave('#deposit-amount', cf);
    </script>
@endsection
