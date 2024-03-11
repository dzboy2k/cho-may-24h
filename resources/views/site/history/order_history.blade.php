@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/history.css') }}' />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container col-12 col-md-10 px-0 mx-auto py-4 content-bounce-margin">
            <h5 class="mb-3">
                @if ($orderType == 'buy')
                    {{ __('history.title_purchase') }}
                @else
                    {{ __('history.title_sell') }}
                @endif
            </h5>
            @php
                $listHeaderKeyLang = ['history.code_orders', 'history.price', 'history.support_limit', 'history.support_time', 'history.purchase_time', 'history.status', 'history.action'];
                $render_data = [];

                foreach ($listOrder as $order) {
                    $price_format = number_format($order->price, 0, '', '.');
                    $receive_support_format = number_format($order->receive_support, 0, '', '.');
                    $html_detail = '<a class="text_table text-primary text-decoration-none" href="' . route('site.history.order_detail', ['id' => $order->id]) . '">' . __('history.detail') . '</a>';
                    $html_status = '<p class="text_table fw-light mb-0 ' . ($order->is_received == 1 && $order->is_paid == 1 ? 'text-success">Thành công' : 'text-warning">Chờ xác nhận') . '</p>';

                    $render_data[] = [$order->id, $price_format, $receive_support_format, $order->expire_limit_month, $order->created_at, $html_status, $html_detail];
                }
            @endphp
            <div class="row mx-0">
                <x-site.history :list-header-key-lang="$listHeaderKeyLang" :list-history="$render_data" />
            </div>
        </div>
    </div>
@endsection
