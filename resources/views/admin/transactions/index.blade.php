@extends("admin.layout.main")
@section('title',__('transaction.transaction_list'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-window-list"></i>
            {{__('transaction.transaction_in_lang')}}
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
                        <form method="get" class="form-search" action="{{route('admin.transactions.search')}}">
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
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.ID') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.type') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.user') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.amount') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.status') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('transaction.created_at') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    @php
                                        $is_plus = $transaction->fluctuation > 0
                                    @endphp
                                    <tr>
                                        <td>
                                            <div
                                                class="text-center">{{$transaction->id}}</div>
                                        </td>
                                        <td>
                                            @if($transaction->type !== null)
                                                <div
                                                    class="text-center">{{config('constants.WALLET_NAME_MAPPED_WITH_TRANSACTION_TYPE')[$transaction->type]}}</div>
                                            @else
                                                <div
                                                    class="text-center">{{config('constants.WALLET_NAME_MAPPED_WITH_TRANSACTION_TYPE')[config('constants.SUPPORT_WALLET_TYPE')]}}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $transaction->wallet->user->name ) > 50 ? mb_substr($transaction->wallet->user->name, 0, 50) . ' ...' : $transaction->wallet->user->name }}</div>
                                        </td>
                                        <td>
                                            @if(@$transaction->type)
                                                <div
                                                    class="text-center {{$is_plus ? 'text-success' : 'text-danger'}}">{{$is_plus ? '+ ' : '- '}}{{ number_format(abs($transaction->fluctuation),0,'.','.')}}
                                                    {{config('constants.WALLET_PRICE_MAPPED_WITH_TRANSACTION_TYPE')[$transaction->type]}}
                                                </div>
                                            @else
                                                <div
                                                    class="text-center {{$is_plus ? 'text-success' : 'text-danger'}}">{{$is_plus ? '+ ' : '- '}}{{ number_format(abs($transaction->fluctuation),0,'.','.')}}
                                                    {{config('constants.WALLET_PRICE_MAPPED_WITH_TRANSACTION_TYPE')[1]}}
                                                </div>
                                            @endif

                                        </td>
                                        <td>
                                            @if(@$transaction->status)
                                                <div
                                                    class="text-center {{config('constants.TRANSACTION_STATUS_TEXT_CLASS_MAPPED_STATUS')[$transaction->status]}}">{{config('constants.TRANSACTION_STATUS_TITLE_MAPPED_STATUS')[$transaction->status]}}
                                                </div>
                                            @else
                                                <div
                                                    class="text-center {{config('constants.TRANSACTION_STATUS_TEXT_CLASS_MAPPED_STATUS')[1]}}">{{config('constants.TRANSACTION_STATUS_TITLE_MAPPED_STATUS')[1]}}
                                                </div>
                                            @endif

                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{  $transaction->created_at }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$transactions->links()}}
                        </div>
                        @if($transactions->count() <= 0)
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
