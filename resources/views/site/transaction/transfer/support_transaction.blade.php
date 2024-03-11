@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-3 my-md-0">
        <div
            class="container px-0 mx-auto py-4 content-bounce-margin d-flex w-100 h-auto justify-content-center align-self-center">
            <div class="col-12 col-md-6 col-lg-4 p-3 bg-white">
                <div class="title">
                    <h5>{{ __('transaction.transfer') }}</h5>
                </div>
                <div>
                    <small class="text-danger">{{ __('transaction.transfer_note') }}</small>
                </div>

                <small class="text-primary ">{{ __('deposit.depre_wallet') }}
                    : {{ number_format(Auth::user()->wallet->get_depreciation_support, 0, ',', '.') }}
                    {{ __('wallet.dm') }}</small>
                <form action="{{ route('support.transfer.handle') }}" method="POST">
                    @csrf
                    <div class="py-3">
                        <h6 class="subtitle">{{ __('transaction.transfer_select_application') }}</h6>
                        <select class="form-select" id="locale" name="locale">
                            <option>{{ __('transaction.transfer_trading_code') }}</option>
                            @foreach ($supportTransactionCanTransfer as $supportTransactionCanTransferItem)
                                <option value="{{ $supportTransactionCanTransferItem->wallet_id }}">
                                    {{ $supportTransactionCanTransferItem->wallet_id }}-{{ $supportTransactionCanTransferItem->support_expired_limit }}-{{ $supportTransactionCanTransferItem->recieve_suppport }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="py-3">
                        <h6 class="subtitle">{{ __('transaction.transfer_account') }}</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <input id="referral_code" name="referral_code"
                                    class="form-control subtitle app-body-text-2 py-2 shadow-none" placeholder="{{ __('transaction.enter_recipient_id') }}"/>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="btn btn-primary shadow-lg border-0 w-100 py-2 btn-texttext-uppercase check-account-btn">
                                    <small>{{ __('transaction.transfer_check') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <small class="text-black-50 account-info-check">
                    </small>
                    <button type="submit"
                        class="btn btn-primary shadow-lg border-0 w-100 py-2 my-3 btn-texttext-uppercase">
                        {{ __('deposit.continue') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const account_owner_title = '{{ __('transaction.account_owner') }}';
        const setAccountInfo = (accountInfo) => {
            const accountInfoElement = document.querySelector('.account-info-check');
            accountInfoElement.innerHTML = `${account_owner_title}: ${accountInfo}`;
        }
        const handleCheckAccount = async () => {
            const referral_code = document.getElementById('referral_code')?.value;
            const resp = await fetch('{{ route('support.check.transfer.target') }}/?referral_code=' +
                referral_code, {
                    headers: {
                        apiKey: authToken,
                    },
                })
            const jsonData = await resp.json();
            if (resp.status >= 400) {
                const alert = {
                    type: 'error'
                };
                alert['content'] = jsonData?.message
                showToast(alert.type, '{{ __('message.notification') }}', alert.content, {
                    position: 'topRight'
                });
                setAccountInfo(jsonData?.message);
            } else {
                setAccountInfo(jsonData);
            }
        }
        $(document).ready(() => {
            const checkAccountBtn = $('.check-account-btn');
            checkAccountBtn.on('click', handleCheckAccount);
        });
    </script>
@endsection
