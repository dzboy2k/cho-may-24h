@extends("admin.layout.main")
@section('title',__('post.unverify_post_list'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-certificate"></i>
            {{__('post.unverify_posts')}}
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
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="dt-not-orderable">
                                        <input type="checkbox" id="select_all">
                                    </th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.title') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.slug') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.price') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.support_limit_received') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.image') }}</th>
                                    <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="row_id" id="checkbox_{{ $post->id }}"
                                                   value="{{$post->id}}">
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $post->title ) > 200 ? mb_substr($post->title, 0, 200) . ' ...' : $post->title }}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $post->slug ) > 200 ? mb_substr($post->slug, 0, 200) . ' ...' : $post->slug }}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{number_format(@$post->price,0,'.','.')}} đ
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ number_format(@$post->receive_support,0,'.','.')}}
                                                đ
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <img src="{{asset(@$post->images[0]->path)}}" width="60">
                                            </div>
                                        </td>
                                        <td class="no-sort no-click bread-actions">
                                            <a class="btn btn-sm btn-danger pull-right delete"
                                               title="{{__('crud.delete')}}"
                                               onclick="showDeleteModal({{$post->id}},'{{$post->title}}')">
                                                <i class="voyager-trash"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.delete')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-primary pull-right edit"
                                               title="{{__('post.verify_post')}}"
                                               href="{{ route('admin.posts.verify.form',['id'=>$post->id]) }}">
                                                <i class="voyager-edit"></i>
                                                <span class="hidden-xs hidden-sm">{{__('post.verify_post')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-warning pull-right view"
                                               title="{{__('crud.read')}}"
                                               href="{{ route('admin.posts.detail',['id'=>$post->id]) }}">
                                                <i class="voyager-eye"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.read')}}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$posts->links()}}
                        </div>
                        @if($posts->count() <= 0)
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
                    if (confirm("{{__('post.confirm_delete_all')}}")) {
                        deleteAll(selectedRows);
                    }
                } else {
                    showToast('warning', '{{__('message.notification')}}', '{{__('post.no_selected')}}', {position: 'topRight'})
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
            const resp = await fetch('{{route('admin.posts.delete.all')}}', {
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
            let uri = '{{route('admin.posts.delete',['id'=>-1])}}'.replace('-1', '') + id;
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
