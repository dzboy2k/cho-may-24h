@extends('admin.layout.main')
@section('title', __('user_posting_plan.st'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-harddrive"></i>
            {{ __('user_posting_plan.users_sub_plan') }}
        </h1>
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
                        <form method="get" class="form-search" action="{{ route('admin.user-posting-plan.search') }}">
                            <div id="search-input">
                                <div class="input-group col-md-12">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('user_posting_plan.search_by_user') }}" name="search_query"
                                        value="{{ @$query }}">
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
                                        <th class="actions text-center dt-not-orderable">
                                            {{ __('user_posting_plan.user_name') }}</th>
                                        <th class="actions text-center dt-not-orderable">
                                            {{ __('user_posting_plan.plan') }}
                                        </th>
                                        <th class="actions text-center dt-not-orderable">
                                            {{ __('user_posting_plan.price_plan') }}</th>
                                        <th class="actions text-center dt-not-orderable">
                                            {{ __('user_posting_plan.sub_date') }}</th>
                                        <th class="actions text-center dt-not-orderable">
                                            {{ __('user_posting_plan.expire_date') }}</th>
                                        <th class="actions text-right dt-not-orderable">
                                            {{ __('voyager::generic.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_users_sub_plans as $user_sub)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id" id="checkbox_{{ $user_sub->id }}"
                                                    value="{{ $user_sub->id }}">
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <a
                                                        href="{{ route('voyager.users.update', ['id' => $user_sub->user->id]) }}">
                                                        {{ $user_sub->user->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <a
                                                        href="{{ route('admin.post-plans.detail', ['id' => $user_sub->package_id]) }}">
                                                        {{ $user_sub->plan->title }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    {{ number_format($user_sub->plan->price_per_month, 0, '.', '.') }}đ
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">{{ $user_sub->created_at }}</div>
                                            </td>
                                            <td>
                                                <div class="text-center">{{ $user_sub->expire_date }}</div>
                                            </td>
                                            <td class="no-sort no-click bread-actions">
                                                <a class="btn btn-sm btn-danger pull-right delete"
                                                    title="{{ __('crud.delete') }}"
                                                    onclick="showDeleteModal({{ $user_sub->id }},'{{ $user_sub->user->name }} {{ __('user_posting_plan.modal_message') }}')">
                                                    <i class="voyager-trash"></i>
                                                    <span class="hidden-xs hidden-sm">{{ __('crud.delete') }}</span>
                                                </a>
                                                <a class="btn btn-sm btn-warning pull-right view"
                                                    title="{{ __('crud.read') }}"
                                                    href="{{ route('admin.user-posting-plan.detail', ['id' => $user_sub->id]) }}">
                                                    <i class="voyager-eye"></i>
                                                    <span class="hidden-xs hidden-sm">{{ __('crud.read') }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $list_users_sub_plans->links() }}
                        </div>
                        @if ($list_users_sub_plans->count() <= 0)
                            <div class="padding-5 row bg-white">
                                <p class="text-center">{{ __('admin.no_data') }}</p>
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
                    if (confirm("{{ __('user_posting_plan.confirm_delete_all') }}")) {
                        deleteAll(selectedRows);
                    }
                } else {
                    showToast('warning', '{{ __('message.notification') }}',
                        '{{ __('user_posting_plan.no_selected') }}', {
                            position: 'topRight'
                        })
                }
            });
            selectAllBox.addEventListener('change', (e) => {
                let rowIds = document.getElementsByName('row_id');
                rowIds.forEach((val) => val.checked = e.target.checked);
            })
        });

        function showDeleteModal(id, name) {
            if (confirm('{{ __('crud.delete_confirm') }}' + ` ${name}?`)) {
                deleted(id);
            }
        }

        async function deleted(id) {
            let uri = '{{ route('admin.user-posting-plan.delete', ['id' => -1]) }}'.replace('-1', '') + id;
            const resp = await fetch(uri, {
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });
            let jsonData = await resp.json();
            let alert = {
                type: 'success'
            };
            if (resp.status >= 400) {
                alert.type = 'error';
            }
            alert['content'] = jsonData?.message
            showToast(alert.type, '{{ __('message.notification') }}', alert.content, {
                position: 'topRight'
            })
            if (resp.status === 200) {
                setTimeout(() => {
                    window.location.assign(window.location.href);
                }, 1000)
            }
        }

        async function deleteAll(selectedId) {
            const resp = await fetch('{{ route('admin.user-posting-plan.delete.all') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(selectedId)
            })
            let jsonData = await resp.json();
            let alert = {
                type: 'success'
            };
            if (resp.status >= 400) {
                alert.type = 'error';
            }
            alert['content'] = jsonData?.message
            showToast(alert.type, '{{ __('message.notification') }}', alert.content, {
                position: 'topRight'
            })
            if (resp.status === 200) {
                setTimeout(() => {
                    window.location.assign(window.location.href);
                }, 1000)
            }
        }
    </script>
@endsection
