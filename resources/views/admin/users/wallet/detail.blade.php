@extends("admin.layout.main")
@section('title','Dashboard')
@section('page_content')
    <div class="container-fluid mr-auto padding-5">
        <div class="row padding-x-2">
            <div class="col-sm-12">
                <h5 class="fw-medium text-black">{{__('admin.wallet_manage')}}</h5>
            </div>
        </div>
        <div class="row padding-x-2">
            <div class="col-12 col-sm-3 my-1 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{__('admin.username')}}:</h6>
                </div>
            </div>
            <div class="col-12 col-sm-9 my-1 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{$user->name}}</h6>
                </div>
            </div>
        </div>

        <div class="row padding-x-2">
            <div class="col-12 col-sm-3 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{__('admin.email')}}:</h6>
                </div>
            </div>
            <div class="col-12 col-sm-9 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{$user->email}}</h6>
                </div>
            </div>
        </div>

        <div class="row padding-x-2">
            <div class="col-12 col-sm-3 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{__('admin.phone')}}:</h6>
                </div>
            </div>
            <div class="col-12 col-sm-9 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{$user->phone}}</h6>
                </div>
            </div>
        </div>

        <div class="row padding-x-2">
            <div class="col-12 col-sm-3 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{__('admin.ID')}}:</h6>
                </div>
            </div>
            <div class="col-12 col-sm-9 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-black">{{$user->referral_code}}</h6>
                </div>
            </div>
        </div>
        <a href="{{route('voyager.user.wallet.edit.form',['id'=>$user->id,'type'=>config('constants.TRANSACTION_TYPE')['PAYMENT_WALLET']])}}">
            <div class="row padding-x-2">
                <div class="col-12 col-sm-3 my-1">
                    <div class="padding-y-1 flex-row">
                        <i class="voyager-wallet padding-r-1 text-primary"></i>
                        <h6 class="fw-medium text-black my-0">{{__('admin.payment_wallet')}}:</h6>
                    </div>
                </div>
                <div class="col-12 col-sm-9 my-1">
                    <div class="padding-y-1">
                        <h6 class="fw-medium text-primary">{{number_format($user_wallet->payment_coin,0,'.','.')}} {{__('wallet.dm')}}</h6>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{route('voyager.user.wallet.edit.form',['id'=>$user->id,'type'=>config('constants.TRANSACTION_TYPE')['SALE_LIMIT_WALLET']])}}">
            <div class="row padding-x-2">
                <div class="col-12 col-sm-3 my-1">
                    <div class="padding-y-1 flex-row">
                        <i class="voyager-wallet padding-r-1 text-black"></i>
                        <h6 class="fw-medium text-black my-0">{{__('admin.sale_limit_wallet')}}:</h6>
                    </div>
                </div>
                <div class="col-12 col-sm-9 my-1">
                    <div class="padding-y-1">
                        <h6 class="fw-medium text-primary">{{number_format($user_wallet->sale_limit,0,'.','.')}} {{__('wallet.vnd')}}</h6>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{route('voyager.user.wallet.edit.form',['id'=>$user->id,'type'=>config('constants.SUPPORT_WALLET_TYPE')])}}">
            <div class="row padding-x-2">
                <div class="col-12 col-sm-3 my-1">
                    <div class="padding-y-1 flex-row">
                        <i class="voyager-wallet padding-r-1 text-warning"></i>
                        <h6 class="fw-medium text-black my-0">{{__('admin.deprecation_support')}}:</h6>
                    </div>
                </div>
                <div class="col-12 col-sm-9 my-1">
                    <div class="padding-y-1">
                        <h6 class="fw-medium text-primary">{{number_format($user_wallet->depreciation_support_limit,0,'.','.')}} {{__('wallet.vnd')}}</h6>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{route('voyager.user.wallet.edit.form',['id'=>$user->id,'type'=>config('constants.TRANSACTION_TYPE')['GET_DEPRECIATION_SUPPORT_WALLET']])}}"">
        <div class="row padding-x-2">
            <div class="col-12 col-sm-3 my-1">
                <div class="padding-y-1 flex-row">
                    <i class="voyager-wallet padding-r-1 text-danger"></i>
                    <h6 class="fw-medium text-black my-0">{{__('admin.get_deprecation')}}:</h6>
                </div>
            </div>
            <div class="col-12 col-sm-9 my-1">
                <div class="padding-y-1">
                    <h6 class="fw-medium text-primary">{{number_format($user_wallet->get_depreciation_support,0,'.','.')}} {{__('wallet.vnd')}}</h6>
                </div>
            </div>
        </div>
        </a>

        <a href="{{route('voyager.user.wallet.edit.form',['id'=>$user->id,'type'=>config('constants.TRANSACTION_TYPE')['MEMBERSHIP']])}}">
            <div class="row padding-x-2">
                <div class="col-12 col-sm-3 my-1">
                    <div class="padding-y-1 flex-row">
                        <i class="voyager-wallet padding-r-1 text-success"></i>
                        <h6 class="fw-medium text-black my-0">{{__('admin.member_point')}}:</h6>
                    </div>
                </div>
                <div class="col-12 col-sm-9 my-1">
                    <div class="padding-y-1">
                        <h6 class="fw-medium text-primary">{{number_format($user->wallet->membership_point ?? 0,0,'.','.')}} {{__('wallet.point')}}</h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
