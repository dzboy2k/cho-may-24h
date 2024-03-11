@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}' />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-between align-items-center my-3">
                    <div class="col-12 col-md-6 align-center-mobile">
                        <h5 class="mb-2">{{ __('history.depreciation_support_limit') }}</h5>
                        <h5 class="text-success fw-bold">
                            {{ number_format(Auth::user()->wallet->depreciation_support_limit, 0, '.', '.') }}
                            {{ __('wallet.vnd') }}
                        </h5>
                    </div>
                    <div
                        class="col-12 col-md-6 my-md-auto d-md-flex align-items-center justify-content-end my-2 align-center-mobile">
                        <a href="{{ route('support.transfer.show') }}" class="me-2">
                            <button
                                class="btn btn-primary rounded border-primary px-5 py-2 subtitle">{{ __('transaction.transfer') }}</button>
                        </a>
                    </div>
                </div>
                @php
                    $dm_unit_lang = __('wallet.dm');
                    $listHeaderKeyLang = ['history.trading_code', 'history.time', 'history.depre_support_limit', 'history.expiration_date', 'history.description'];
                    $receiveTypes = [__('history.from_post'), __('history.from_transfer'), __('history.from_referral')];
                    $render_data = [];

                    foreach ($suppportTransactions as $suppportTransaction) {
                        $expiration_date = \Carbon\Carbon::parse($suppportTransaction->expiration_date);

                        if ($expiration_date->isFuture()) {
                            $expiration_text = $expiration_date;
                        } else {
                            $expiration_text = '<span class="text-danger text_table">' . __('history.expiration') . '</span>';
                        }

                        $html_fluctuation = '<span class="text_table ' . ($suppportTransaction->fluctuation < 0 ? 'text-danger' : 'text-success') . '">' . ($suppportTransaction->fluctuation > 0 ? '+' : '') . number_format($suppportTransaction->fluctuation, 0, ',', '.') . '&nbsp;' . $dm_unit_lang . '</span>';
                        $receive_support_format = number_format($suppportTransaction->receive_support, 0, '', '.');
                        $render_data[] = [$suppportTransaction->id, $suppportTransaction->created_at, $html_fluctuation, $expiration_text, $receiveTypes[$suppportTransaction->receive_type]];
                    }
                @endphp
                <div class="row mx-0">
                    <x-site.history :list-header-key-lang="$listHeaderKeyLang" :list-history="$render_data" />
                </div>
            </div>
        </div>
    </div>
@endsection
