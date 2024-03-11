@php
    $dm_unit_lang = __('wallet.dm');
    $listHeaderKeyLang = ['history.trading_code', 'history.time', 'history.fluctuation', 'history.status', 'history.description'];
    $render_data = [];

    foreach ($transactions as $transaction) {
        $html_fluctuation = '<span class="text_table ' . ($transaction->fluctuation < 0 ? 'text-danger' : 'text-success') . '">' . ($transaction->fluctuation > 0 ? '+' : '') . number_format($transaction->fluctuation, 0, ',', '.') . '&nbsp;' . $dm_unit_lang . '</span>';
        $status_transaction = $transaction->status;
        $status_message = '';

        switch ($status_transaction) {
            case config('constants.TRANSACTION_STATUS')['SUCCESS']:
                $status_message = __('history.success');
                $textColor = 'text-success';
                break;
            case config('constants.TRANSACTION_STATUS')['PENDING']:
                $status_message = __('history.pending');
                $textColor = 'text-warning';
                break;
            default:
                $status_message = __('history.failed');
                $textColor = 'text-danger';
        }

        $html_status = '<span class="text_table ' . $textColor . '">' . $status_message . '</span>';
        $render_data[] = [$transaction->id, $transaction->created_at, $html_fluctuation, $html_status, $transaction->description];
    }
@endphp
<p class="mb-2 subtitle fw-light"> {{ __('history.history_transactions') }} </p>
<div class="row mx-0">
    <x-site.history :list-header-key-lang="$listHeaderKeyLang" :list-history="$render_data" />
</div>
<div class="d-flex justify-content-center mt-2">
    {{ $transactions->onEachSide(1)->links('site.components.pagination.pagination') }}
</div>
