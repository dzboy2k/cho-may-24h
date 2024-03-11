@extends('site.layouts.main')
@section('content')
    @php
        $isOrderSuccessful = $order->is_received == 1 && $order->is_paid == 1;
        $userIdCurrent = Auth::id();
        $authorId = $order->post->author_id;
        $routeSetPaid = route('site.order.set-paid', ['id' => $order->id]);
        $routeSetReceived = route('site.order.set-received', ['id' => $order->id]);
    @endphp
    <div class="container-fluid bg-secondary">
        <div class="container px-0 py-4 content-bounce-margin">
            <div class="col-12 col-md-8 col-lg-5 mx-auto bg-white p-3 d-flex row justify-content-center">
                <div>
                    <div>
                        <a class="d-inline text-reset" data-toggle="tooltip" title="{{ __('history.back') }}"
                            href="{{ $userIdCurrent == $authorId ? route('site.history.order_history.sell') : route('site.history.order_history.buy') }}">
                            <i class="fa-solid fa-angle-left"></i></a>
                        <h5 class="d-inline"> {{ __('history.orders') }} #{{ $order->id }}</h5>
                    </div>
                    <p class="caption text-danger fw-light mb-0 mt-3">{{ __('history.note_with_COD') }}</p>
                    <ul class="text-danger caption fw-light">
                        <li>{{ __('history.note_transaction') }}</li>
                        <li>{{ __('history.note_support_limit') }}</li>
                    </ul>
                </div>
                <table class="table table-borderless mx-auto">
                    <tbody>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.code_orders') }}</td>
                            <td class="subtitle fw-light">{{ $order->id }}</td>
                        </tr>
                        @if ($userIdCurrent == $authorId)
                            <tr>
                                <td class="h5 subtitle fw-bold">{{ __('history.buyer') }}</td>
                                <td class="subtitle fw-light">
                                    <a href="{{ route('user.info', $order->user->referral_code) }}"
                                        class="text-primary text-decoration-none">
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.product_detail') }}</td>
                            <td class="subtitle fw-light">
                                <a class="text-primary text-decoration-none"
                                    href="{{ route('post.detail', ['slug' => $order->post->slug]) }}">
                                    {{ __('history.view_details') }} </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.price') }}</td>
                            <td class="subtitle fw-light">{{ number_format($order->price, 0, '', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.support_limit') }}</td>
                            <td class="subtitle fw-light">{{ number_format($order->receive_support, 0, '', '.') }}
                                {{ __('wallet.vnd') }}</td>
                        </tr>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.support_time') }}</td>
                            <td class="subtitle fw-light">{{ $order->expire_limit_month }}</td>
                        </tr>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.purchase_time') }}</td>
                            <td class="subtitle fw-light">{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <td class="h5 subtitle fw-bold">{{ __('history.status') }}</td>
                            <td class="subtitle fw-light">
                                <span class="subtitle fw-light {{ $isOrderSuccessful ? 'text-success' : 'text-warning' }}">
                                    {{ $isOrderSuccessful ? __('history.success') :
                                        ($userIdCurrent != $authorId && $order->is_received == 1 ? __('history.wait_confirmation_payment')
                                        : ($userIdCurrent == $authorId && $order->is_paid == 1 ? __('history.wait_confirmation_receipt')
                                        : __('history.wait_confirmation'))) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <form id="confirm-order-form"
                        action="{{ $userIdCurrent == $authorId ? $routeSetPaid : $routeSetReceived }}" method="post">
                        @csrf
                        <button onclick="confirmOrder()"
                            class="btn-primary btn border-0 {{ ($order->is_paid == 1 && $userIdCurrent == $authorId) || ($order->is_received == 1 && $userIdCurrent != $authorId) ? 'd-none' : '' }}"
                            type="submit">
                            {{ $userIdCurrent == $authorId ? __('history.set_paid') : __('history.set_received') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let isSubmit = false;
        const confirmOrderForm = document.getElementById('confirm-order-form');

        function confirmOrder() {
            if (confirm("Bạn sẽ không thể hoàn tác, bạn có chắc chắn chưa?")) {
                isSubmit = true;
                confirmOrderForm.submit();
            }
        }

        confirmOrderForm.addEventListener('submit', function(event) {
            if (!isSubmit) {
                event.preventDefault();
            }
        });
    </script>
@endsection
