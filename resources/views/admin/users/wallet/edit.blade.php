@extends("admin.layout.main")
@section('title','Dashboard')
@section('page_content')
    <div class="container-fluid mr-auto padding-5">
        <div class="row padding-x-2">
            <div class="col-sm-12 my-1">
                <h5 class="fw-medium text-black">{{__('admin.edit_wallet',['wallet'=>$wallet_name,'name'=>$user->name])}}</h5>
            </div>
        </div>
        <form
            action="{{$is_support_transaction ? route('voyager.user.support_wallet.edit') : route('voyager.user.wallet.edit')}}"
            method="post">
            @csrf
            <input type="number" name="type" value="{{$type}}" class="form-control padding-y-3 hide"/>
            <input type="number" name="user_id" value="{{$user->id}}" class="form-control padding-y-3 hide"/>
            <div class="row padding-y-1 padding-x-2">
                <div class="col-12 col-md-4 padding-x-2 my-2">
                    <h6 class="text-black subtitle fw-medium">{{__('admin.wallet.enter_coin')}}</h6>
                    <input type="number" name="amount" class="form-control padding-y-3"
                           placeholder="{{__('admin.wallet.enter_coin')}}"/>
                    @error('amount')
                    <span class="text-danger subtitle fw-light">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-12 flex-row my-2">
                    @if(!$is_support_transaction)
                        <div class="">
                            <input value="{{config('constants.TRANSACTION_ACTIONS')['PLUS']}}" id="action" type="radio"
                                   name="action" checked/>
                            <label for="action" class="text-black">{{__('admin.wallet.plus')}}</label>
                        </div>
                        <div class="padding-x-2">
                            <input value="{{config('constants.TRANSACTION_ACTIONS')['DECENT']}}" id="action"
                                   type="radio"
                                   name="action"/>
                            <label for="action" class="text-black">{{__('admin.wallet.descent')}}</label>
                        </div>
                    @endif
                </div>
                @if($is_support_transaction)
                    <div class="col-12 col-md-4 padding-x-2 my-1">
                        <h6 class="text-black subtitle fw-medium">{{__('admin.wallet.expired_date')}}</h6>
                        <input name="expired_date" b type="date"
                               class="form-control padding-y-3"
                               placeholder="{{__('admin.wallet.expired_date')}}"/>
                        @error('expired_date')
                        <span class="text-danger subtitle fw-light">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12"></div>
                @endif
                <div class="col-12 col-md-4 padding-x-2 my-1">
                    <h6 class="text-black subtitle fw-medium">{{__('admin.wallet.reason')}}</h6>
                    <input multiple name="description" class="form-control padding-y-3"
                           placeholder="{{__('admin.wallet.reason')}}"/>
                    @error('description')
                    <span class="text-danger subtitle fw-light">{{$message}}</span>
                    @enderror
                </div>

            </div>
            <div class="row padding-x-2">
                <div class="col-12 col-md-4 my-2">
                    <button
                        class="btn btn-primary subtitle padding-y-2 btn-block">{{__('admin.wallet.confirm')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
