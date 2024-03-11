@extends('admin.layout.main')
@section('title')
    {{__('page.read_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-documentation"></i> {{ __('page.reading') }} {{$page->title}}
        <a href="{{ route('admin.pages.edit.form',['id'=>$page->id]) }}" class="btn btn-info">
            <i class="glyphicon glyphicon-pencil"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
        </a>
        <a title="{{ __('voyager::generic.delete') }}" id="btn-del" class="btn btn-danger delete"
           data-id="{{$page->id}}">
            <i class="voyager-trash"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a>
        <a href="{{ route('admin.pages') }}" class="btn btn-warning">
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
                        <h4 class="text-black">{{__('page.title')}}</h4>
                        <p style="margin: 0 6px">{{$page->title}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class=" text-black">{{__('page.slug')}}</h4>
                        <p style="margin: 0 6px">{{$page->slug}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.body')}}</h4>
                        {!! html_entity_decode(@$page->body) !!}
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.image')}}</h4>
                        <img src="{{asset(@$page->image)}}" class="image-responsive"/>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.show_in_home')}}</h4>
                        <p style="margin: 0 6px">{{$page->show_in_home_slide == 1 ? __('page.yes') : __('page.no')}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.is_service')}}</h4>
                        <p style="margin: 0 6px">{{$page->is_service == 1 ? __('page.yes') : __('page.no')}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.show_in_header')}}</h4>
                        <p style="margin: 0 6px">{{$page->show_in_header == 1 ? __('page.yes') : __('page.no')}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.created_at')}}</h4>
                        <p style="margin: 0 6px">{{@$page->created_at}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h4 class="text-black">{{__('page.updated_at')}}</h4>
                        <p style="margin: 0 6px">{{@$page->updated_at}}</p>
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
                let uri = '{{route('admin.pages.delete',['id'=>'#'])}}'.replace('#', '') + id;
                if (confirm("{{__('page.confirm_delete')}}")) {
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
                            window.location.assign('{{route('admin.pages')}}');
                        }, 1000)
                    }
                }
            })
        })
    </script>
@endsection
