@extends("admin.layout.main")
@section('title',__('post_plan.plan_list'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-harddrive"></i>
            {{__('post_plan.st')}}
        </h1>
        <a href="{{ route('admin.post-plans.create.form') }}" class="btn btn-success btn-add-new"
           style="margin-top: 5px">
            <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </a>
        <a id="delete-all-btn" class="btn btn-danger btn-add-delete-all">
            <i class="voyager-trash"></i> <span>{{ __('voyager::generic.bulk_delete') }}</span>
        </a>
    </div>
@endsection
@section('page_content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form method="get" class="form-search" action="{{route('admin.post-plans.search')}}">
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
                                    <th class="dt-not-orderable">
                                        <input type="checkbox" id="select_all">
                                    </th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post_plan.title') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post_plan.image') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post_plan.summary') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post_plan.price_per_month') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post_plan.created_at') }}</th>
                                    <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($post_plans as $st)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="row_id" id="checkbox_{{ $st->id }}"
                                                   value="{{$st->id}}">
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $st->title ) > 200 ? mb_substr($st->title, 0, 200) . ' ...' : $st->title }}</div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <img src="{{asset(@$st->image)}}"
                                                     alt="page-image" width="60" height="60" style="object-fit: cover">
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $st->summary ) > 20 ? mb_substr($st->summary , 0, 20) . ' ...' : $st->summary}}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ number_format($st->price_per_month,0,'.','.')}}đ</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{$st->created_at}}</div>
                                        </td>
                                        <td class="no-sort no-click bread-actions">
                                            <a class="btn btn-sm btn-danger pull-right delete"
                                               title="{{__('crud.delete')}}"
                                               onclick="showDeleteModal({{$st->id}},'{{$st->title}}')">
                                                <i class="voyager-trash"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.delete')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-primary pull-right edit"
                                               title="{{__('crud.edit')}}"
                                               href="{{ route('admin.post-plans.edit.form',['id'=>$st->id]) }}">
                                                <i class="voyager-edit"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.edit')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-warning pull-right view"
                                               title="{{__('crud.read')}}"
                                               href="{{ route('admin.post-plans.detail',['id'=>$st->id]) }}">
                                                <i class="voyager-eye"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.read')}}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$post_plans->links()}}
                        </div>
                        @if($post_plans->count() <= 0)
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
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            const selectAllBox = document.getElementById('select_all');
            const btnDeleteAll = document.getElementById('delete-all-btn');

            btnDeleteAll.addEventListener('click', (e) => {
                let rowIds = document.getElementsByName('row_id');
                let selectedRows = [];
                for (let item of rowIds) {
                    if (item.checked) {
                        selectedRows.push(item.value);
                    }
                }
                if (selectedRows.length > 0) {
                    if (confirm("{{__('status.confirm_delete_all')}}")) {
                        deleteAll(selectedRows);
                    }
                } else {
                    showToast('warning', '{{__('message.notification')}}', '{{__('post_plan.no_selected')}}', {position: 'topRight'})
                }
            });
            selectAllBox.addEventListener('change', (e) => {
                let rowIds = document.getElementsByName('row_id');
                rowIds.forEach((val) => val.checked = e.target.checked);
            })
        });

        function showDeleteModal(id, name) {
            if (confirm('{{__('crud.delete_confirm')}}' + ` ${name}?`)) {
                deleted(id);
            }
        }

        async function deleteAll(selectedId) {
            const resp = await fetch('{{route('admin.post-plans.delete.all')}}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                body: JSON.stringify(selectedId)
            })
            let jsonData = await resp.json();
            let alert = {type: 'success'};
            if (resp.status >= 400) {
                alert.type = 'error';
            }
            alert['content'] = jsonData?.message
            showToast(alert.type, '{{__('message.notification')}}', alert.content, {position: 'topRight'})
            if (resp.status === 200) {
                setTimeout(() => {
                    window.location.assign(window.location.href);
                }, 1000)
            }
        }

        async function deleted(id) {
            let uri = '{{route('admin.post-plans.delete',['id'=>-1])}}'.replace('-1', '') + id;
            const resp = await fetch(uri, {
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
            });
            let jsonData = await resp.json();
            let alert = {type: 'success'};
            if (resp.status >= 400) {
                alert.type = 'error';
            }
            alert['content'] = jsonData?.message
            showToast(alert.type, '{{__('message.notification')}}', alert.content, {position: 'topRight'})
            if (resp.status === 200) {
                setTimeout(() => {
                    window.location.assign(window.location.href);
                }, 1000)
            }
        }
    </script>
@endsection
