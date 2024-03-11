@php
    $user = Auth::user();
@endphp
<div class="d-flex flex-column justify-content-center align-items-center pb-5 mb-4 mb-md-0 pb-md-0 w-100">
    <div class="d-flex justify-content-start align-items-center w-100 bg-white p-2">
        @if ($user)
            <a href="{{ route('user.info', $user->referral_code) }}" class="d-flex text-decoration-none text-reset">
                <div class="position-relative">
                    <img src="{{ asset($user->avatar) }}" class="object-fit-cover rounded-circle avatar-menu-footer">
                    <a href="{{ route('profile.edit.form', $user->id) }}" class="text-reset edit-profile-icon">
                        <img src="{{ asset('images/pencil-circle.svg') }}" alt="pencil icon">
                    </a>
                </div>
            </a>
            <a href="{{ route('user.info', $user->referral_code) }}" class="d-flex text-decoration-none text-reset">
                <div class="d-flex flex-column mx-3">
                    <p class="subtitle my-0">{{ $user->name }}</p>
                    <p class="caption fw-medium my-0">{{ __('user_info.ID') }}: {{ $user->referral_code }}</p>
                    <p class="caption fw-medium my-0">{{ __('user_info.phone') }}: {{ $user->phone }}</p>
                </div>
            </a>
        @else
            <a href="{{ route('auth.login.form') }}" class="d-flex text-decoration-none text-reset">
                <img src="{{ asset('images/user-default-avt.svg') }}"
                     class="object-fit-cover rounded-circle avatar-menu-footer" alt="avatar">
                <div class="d-flex mx-3 justify-content-center align-items-center">
                    <p class="subtitle my-0"> {{ __('auth.login') }}/{{ __('auth.register') }} </p>
                </div>
            </a>
        @endif
    </div>
    <div class="d-flex flex-column justify-content-center py-2 px-3 w-100 bg-white">
        <a class="nav-link"
           href="{{ $user ?  route('site.history.transaction', ['history_type' => config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET']]) : route('auth.login.form') }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-wallet text-primary"></i>
                    <p class="fw-light subtitle my-0 mx-2">{{ __('wallet.pay_wallet') }}</p>
                </div>
                <p class="my-0 mx-2 subtitle text-primary">
                    {{ number_format(@$user->wallet->payment_coin, 0, ',', '.') }}
                    {{ __('wallet.dm') }}</p>
            </div>
        </a>
        <a class="nav-link"
           href="{{ $user ? route('site.history.transaction', ['history_type' => config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET']]) : route('auth.login.form') }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-wallet"></i>
                    <p class="fw-light subtitle my-0 mx-2">{{ __('wallet.sale_limit_wallet') }}</p>
                </div>
                <p class="my-0 mx-2 subtitle text-primary">
                    {{ number_format(@$user->wallet->sale_limit, 0, ',', '.') }}
                    {{ __('wallet.vnd') }}</p>
            </div>
        </a>
        <a class="nav-link" href="{{ $user ?  route('site.history.support.transaction') : route('auth.login.form') }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-wallet text-warning"></i>
                    <p class="fw-light subtitle my-0 mx-2">{{ __('wallet.support_limit_wallet') }}</p>
                </div>
                <p class="my-0 mx-2 subtitle text-primary">
                    {{ number_format(@$user->wallet->depreciation_support_limit) }}
                    {{ __('wallet.vnd') }}</p>
            </div>
        </a>
        <a class="nav-link"
           href="{{ $user ? route('site.history.transaction', ['history_type' => config('constants.TRANSACTION_TYPE')['GET_DEPRECIATION_SUPPORT_WALLET']]) : route('auth.login.form') }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-wallet text-danger"></i>
                    <p class="fw-light subtitle my-0 mx-2">{{ __('wallet.received_support') }}</p>
                </div>
                <p class="my-0 mx-2 subtitle text-primary">
                    {{ number_format(@$user->wallet->get_depreciation_support, 0, ',', '.') }}
                    {{ __('wallet.vnd') }}</p>
            </div>
        </a>
        <a class="nav-link"
           href="{{ $user ? route('site.history.transaction', ['history_type' => config('constants.TRANSACTION_TYPE')['MEMBERSHIP']]) : route('auth.login.form') }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-wallet text-success"></i>
                    <p class="fw-light subtitle my-0 mx-2">{{ __('wallet.member_point') }}</p>
                </div>
                <p class="my-0 mx-2 subtitle text-primary">{{ number_format(@$user->wallet->membership_point, 0, ',', '.') }}
                    {{ __('user_info.point') }}
                </p>
            </div>
        </a>
    </div>
    <div class="d-flex flex-column w-100">
        {{ menu('user', 'site.components.menu.user_options') }}
    </div>
</div>
