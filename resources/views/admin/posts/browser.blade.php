@extends('admin.layout.main')
@section('title')
    {{__('post.read_title')}}
@endsection
@section('header')
    <h1 class="page-title" style="margin-bottom: 20px">
        <i class="voyager-documentation"></i> {{ __('post.reading') }} {{$post->title}}
        <a title="{{ __('voyager::generic.delete') }}" id="btn-del" class="btn btn-danger delete"
           data-id="{{$post->id}}">
            <i class="voyager-trash"></i> <span
                class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a>
        <a href="{{ $post->post_state === 1 ? route('admin.posts') : route('admin.posts.unverify') }}"
           class="btn btn-warning">
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
                        <h1 class="h4 text-black">{{__('post.title')}}</h1>
                        <p style="margin: 0 6px">{{$post->title}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.slug')}}</h1>
                        <p style="margin: 0 6px">{{$post->slug}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.price')}}</h1>
                        <p style="margin: 0 6px">{{number_format($post->price,0,'.','.')}}đ</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.support_limit_received')}}</h1>
                        <p style="margin: 0 6px">{{number_format(@$post->receive_support,0,'.','.')}}đ/{{__('post.day')}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.support_percent')}}</h1>
                        <p style="margin: 0 6px">{{number_format($post->support_limit,0,'.','.')}}đ</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.max_month_support')}}</h1>
                        <p style="margin: 0 6px">{{$post->expire_limit_month}} {{__('post_detail.month')}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.desc')}}</h1>
                        <div style="margin: 0 6px" class="post-description">{!!html_entity_decode(@$post->description)!!}</div>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.info')}}</h1>
                        <div style="margin: 0 6px">{!!html_entity_decode(@$post->addition_info)!!}</div>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.location')}}</h1>
                        <p style="margin: 0 6px">{{@$post->address}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.views')}}</h1>
                        <p style="margin: 0 6px">{{@$post->amount_view}}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.created_at')}}</h1>
                        <p style="margin: 0 6px">{{@$post->created_at}}</p>
                    </div>
                    @if(@$post->release_date)
                        <div class="panel-body" style="padding:20px;">
                            <h1 class="h4 text-black">{{__('post.release_date')}}</h1>
                            <p style="margin: 0 6px">{{@$post->release_date}}</p>
                        </div>
                    @endif
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.updated_at')}}</h1>
                        <p style="margin: 0 6px">{{@$post->updated_at}}</p>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{__('post.image')}}</h1>
                        <img class="img-responsive w-50" src="{{asset(@$post->images[0]->path)}}"
                             alt="{{@$brand->images[0]->alt}}"/>
                    </div>
                    <hr style="margin:0;">
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
                let uri = '{{route('admin.posts.delete',['id'=>'#'])}}'.replace('#', '') + id;
                if (confirm("{{__('post.confirm_delete')}}")) {
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
                            window.location.assign('{{route('admin.posts')}}');
                        }, 1000)
                    }
                }
            })
        })
    </script>
@endsection
