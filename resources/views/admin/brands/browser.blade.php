@extends('admin.layout.main')
@section('title')
    {{__('brand.read_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-list"></i> {{ __('brand.reading') }} {{$brand->name}}
        <a href="{{ route('admin.brands.edit.form',['id'=>$brand->id]) }}" class="btn btn-info">
            <i class="glyphicon glyphicon-pencil"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
        </a>
        <a title="{{ __('voyager::generic.delete') }}" id="btn-del" class="btn btn-danger delete"
           data-id="{{$brand->id}}">
            <i class="voyager-trash"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a>
        <a href="{{ route('admin.brands') }}" class="btn btn-warning">
            <i class="glyphicon glyphicon-list"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
        </a>
    </h1>
@endsection
@section('page_content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('brand.name')}}</h1>
                        <p style="margin: 0 6px">{{$brand->name}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('brand.image')}}</h1>
                        <img class="img-responsive" src="{{asset(@$brand->image->path)}}"
                             alt="{{@$brand->image->alt}}"/>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('brand.created_at')}}</h1>
                        <p style="margin: 0 6px">{{$brand->created_at}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('brand.updated_at')}}</h1>
                        <p style="margin: 0 6px">{{$brand->updated_at}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            const btnDelete = document.getElementById('btn-del');
            btnDelete.addEventListener('click', async (e) => {
                let id = btnDelete.dataset.id;
                let uri = '{{route('admin.brands.delete',['id'=>-1])}}'.replace('-1', '') + id;
                if (confirm("{{__('brand.confirm_delete')}}")) {
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
                            window.location.assign('{{route('admin.brands')}}');
                        }, 1000)
                    }
                }
            })
        })
    </script>
@endsection
