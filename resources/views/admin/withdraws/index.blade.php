@extends("admin.layout.main")
@section('title',__('withdraw.withdraw_list'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-window-list"></i>
            {{__('withdraw.withdraw_in_lang')}}
        </h1>
    </div>
@endsection
@section('page_content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form method="get" class="form-search" action="{{route('admin.withdraws.search')}}">
                            <div id="search-input">
                                <div class="input-group col-md-12">
                                    <input type="text" class="form-control"
                                           placeholder="{{ __('voyager::generic.search') }}" name="search_query"
                                           value="{{@$query}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-lg" type="submit">
                                            <i class="voyager-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.ID') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.fluctuation') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.bank_name') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.bank_account') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.bank_owner') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.bank_branch') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.status') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.description') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.created_at') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('withdraw.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($request_withdraw as $withdraw)
                                    <tr>
                                        <td>
                                            <div class="text-center">{{$withdraw->id}}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{number_format($withdraw->fluctuation,0,'.','.')}} {{__('wallet.vnd')}}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">{{$withdraw->bank_name}}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">{{$withdraw->bank_account}}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">{{$withdraw->bank_owner}}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">{{$withdraw->bank_branch}}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center subtitle {{config('constants.TRANSACTION_STATUS_TEXT_CLASS_MAPPED_STATUS')[$withdraw->status]}}">{{config('constants.TRANSACTION_STATUS_TITLE_MAPPED_STATUS')[$withdraw->status]}}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{strlen($withdraw->description) > 50 ? substr($withdraw->description,0,50) .'...' : $withdraw->description}}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">{{  $withdraw->created_at }}</div>
                                        </td>
                                        @if($withdraw->status && $withdraw->status == config('constants.TRANSACTION_STATUS')['PENDING'])
                                            <td class="no-sort no-click bread-actions">
                                                <a class="btn btn-sm btn-primary pull-right view"
                                                   href="{{ route('admin.withdraws.verify',['id'=>$withdraw->id])}}">
                                                    <span class="hidden-xs hidden-sm">{{__('withdraw.verify')}}</span>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$request_withdraw->links()}}
                        </div>
                        @if($request_withdraw->count() <= 0)
                            <div class="padding-5 row bg-white">
                                <p class="text-center">{{__('admin.no_data')}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
