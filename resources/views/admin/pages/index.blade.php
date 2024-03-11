@extends("admin.layout.main")
@section('title',__('page.page_list'))
@section('header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-documentation"></i>
            {{__('admin.page')}}
        </h1>
        <a href="{{ route('admin.pages.create.form') }}" class="btn btn-success btn-add-new"
           style="margin-top: 5px">
            <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
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
                        <form method="get" class="form-search" action="{{route('admin.pages.search')}}">
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
                                    <th class="actions text-center dt-not-orderable">{{ __('page.title') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.slug') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('page.show_in_home') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('page.status') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('page.image') }}</th>
                                    <th class="actions text-center dt-not-orderable">{{ __('post.created_at') }}</th>
                                    <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pages as $page)
                                    <tr>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $page->title ) > 20 ? mb_substr($page->title, 0, 20) . ' ...' : $page->title }}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ mb_strlen( $page->slug ) > 20 ? mb_substr($page->slug, 0, 20) . ' ...' : $page->slug }}</div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{ $page->show_in_home_slide == 1 ? __('page.yes') : __('page.no')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{$page->status}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <img src="{{asset(@$page->image)}}"
                                                     alt="page-image" width="60">
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-center">{{$page->created_at }}</div>
                                        </td>
                                        <td class="no-sort no-click bread-actions">
                                            <a class="btn btn-sm btn-danger pull-right delete"
                                               title="{{__('crud.delete')}}"
                                               onclick="showDeleteModal({{$page->id}},'{{$page->title}}')">
                                                <i class="voyager-trash"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.delete')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-primary pull-right edit"
                                               title="{{__('crud.edit')}}"
                                               href="{{ route('admin.pages.edit.form',['id'=>$page->id]) }}">
                                                <i class="voyager-edit"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.edit')}}</span>
                                            </a>
                                            <a class="btn btn-sm btn-warning pull-right view"
                                               title="{{__('crud.read')}}"
                                               href="{{ route('admin.pages.detail',['id'=>$page->id]) }}">
                                                <i class="voyager-eye"></i>
                                                <span class="hidden-xs hidden-sm">{{__('crud.read')}}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$pages->links()}}
                        </div>
                        @if($pages->count() <= 0)
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
        function showDeleteModal(id, name) {
            if (confirm('{{__('crud.delete_confirm')}}' + ` ${name}?`)) {
                deleted(id);
            }
        }

        async function deleted(id) {
            let uri = '{{route('admin.pages.delete',['id'=>-1])}}'.replace('-1', '') + id;
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
