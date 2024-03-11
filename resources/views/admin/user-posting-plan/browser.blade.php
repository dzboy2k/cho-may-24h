@extends('admin.layout.main')
@section('title')
    {{ __('user_posting_plan.read_title') }}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-shop"></i> {{ __('user_posting_plan.reading') }} {{ $user_sub_plan->user->name }}
        <a title="{{ __('voyager::generic.delete') }}" id="btn-del" class="btn btn-danger delete"
            data-id="{{ $user_sub_plan->id }}">
            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a>
        <a href="{{ route('admin.user.posting.plan') }}" class="btn btn-warning">
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
                        <h1 class="h4 text-black">{{ __('user_posting_plan.user_name') }}</h1>
                        <a style="margin: 0 6px" href="{{ route('voyager.users.update', ['id' => $user_sub_plan->user->id]) }}">
                            {{ $user_sub_plan->user->name }}
                        </a>
                    </div>
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.plan') }}</h1>
                        <a style="margin: 0 6px"
                            href="{{ route('admin.post-plans.detail', ['id' => $user_sub_plan->package_id]) }}">
                            {{ $user_sub_plan->plan->title }}
                        </a>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.price_plan') }}</h1>
                        <p style="margin: 0 6px">{{ number_format($user_sub_plan->plan->price_per_month, 0, '.', '.') }} đ</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.des_plan') }}</h1>
                        <div style="margin: 0 6px" class="post-description" id="description">{!! preg_replace(config('constants.SCRIPT_TAG_REGEX'), '', html_entity_decode(@$user_sub_plan->plan->description)) !!}</div>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.summary') }}</h1>
                        <div style="margin: 0 6px" class="post-description" id="description">{!! preg_replace(config('constants.SCRIPT_TAG_REGEX'), '', html_entity_decode(@$user_sub_plan->plan->summary)) !!}</div>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.sub_date') }}</h1>
                        <p style="margin: 0 6px">{{ @$user_sub_plan->updated_at }}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-body" style="padding:20px;">
                        <h1 class="h4 text-black">{{ __('user_posting_plan.expire_date') }}</h1>
                        <p style="margin: 0 6px">{{ @$user_sub_plan->updated_at }}</p>
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
                let uri = '{{ route('admin.user-posting-plan.delete', ['id' => -1]) }}'.replace('-1',
                    '') + id;
                if (confirm("{{ __('user_posting_plan.confirm_delete') }}")) {
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
                            window.location.assign('{{ route('admin.user.posting.plan') }}');
                        }, 1000)
                    }
                }
            })
        })
    </script>
@endsection
