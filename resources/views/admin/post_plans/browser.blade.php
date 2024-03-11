@extends('admin.layout.main')
@section('title')
    {{__('post_plan.read_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-shop"></i> {{ __('post_plan.reading') }} {{$post_plan->title}}
        <a href="{{ route('admin.post-plans.edit.form',['id'=>$post_plan->id]) }}" class="btn btn-info">
            <i class="glyphicon glyphicon-pencil"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
        </a>
        <a title="{{ __('voyager::generic.delete') }}" id="btn-del" class="btn btn-danger delete"
           data-id="{{$post_plan->id}}">
            <i class="voyager-trash"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a>
        <a href="{{ route('admin.post-plans') }}" class="btn btn-warning">
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
                        <h1 class="h4 text-black">{{__('post_plan.title')}}</h1>
                        <p style="margin: 0 6px">{{$post_plan->title}}</p>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.summary')}}</h1>
                        <p style="margin: 0 6px">{{$post_plan->summary}}</p>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.description')}}</h1>
                        <div style="margin: 0 6px" class="post-description"
                             id="description">{!! preg_replace(config('constants.SCRIPT_TAG_REGEX'),'',html_entity_decode($post_plan->description)) !!}</div>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.price_per_month')}}</h1>
                        <p style="margin: 0 6px">{{number_format($post_plan->price_per_month,0,'.','.')}} đ</p>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.image')}}</h1>
                        <img src="{{asset($post_plan->image)}}"
                             style="width: 100%;max-height: 350px;object-fit: cover"/>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.created_at')}}</h1>
                        <p style="margin: 0 6px">{{$post_plan->created_at}}</p>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post_plan.updated_at')}}</h1>
                        <p style="margin: 0 6px">{{$post_plan->updated_at}}</p>
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
                let uri = '{{route('admin.post-plans.delete',['id'=>-1])}}'.replace('-1', '') + id;
                if (confirm("{{__('post_plan.confirm_delete')}}")) {
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
                            window.location.assign('{{route('admin.post-plans')}}');
                        }, 1000)
                    }
                }
            })
        })
    </script>
@endsection
