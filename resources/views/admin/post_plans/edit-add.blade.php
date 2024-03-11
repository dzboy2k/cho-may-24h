@extends('admin.layout.main')
@section('page_title')
    {{__($is_add ? 'post_plan.add_title' : 'post_plan.edit_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="icon voyager-harddrive"></i>
        {{__('post_plan.edit_or_add',['attribute'=>$is_add ? __('post_plan.add') : __('post_plan.edit')])}}
    </h1>
@endsection
@section('page_content')
    <div class="page-content container-fluid">

        <form class="form-edit-add" role="form"
              action="{{$is_add ? route('admin.post-plans.create') : route('admin.post-plans.edit')}}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            @if(!$is_add)
                                <div class="form-group">
                                    <label for="name">{{ __('post_plan.id') }}</label>
                                    <input readonly id="id" type="text" class="form-control" name="id"
                                           value="{{ $post_plan->id ?? old('id') }}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">{{ __('post_plan.title') }}</label>
                                <input required id="name" type="text" class="form-control" name="title"
                                       placeholder="{{ __('post_plan.title') }}"
                                       value="{{ $post_plan->title ?? old('title') }}">
                                @error('title')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('post_plan.price_per_month') }}</label>
                                <input required id="name" min="1" type="number" class="form-control"
                                       name="price_per_month"
                                       max="2000000000"
                                       placeholder="{{ __('post_plan.price_per_month') }}"
                                       value="{{ $post_plan->price_per_month ?? old('price_per_month') }}">
                                @error('price_per_month')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('post_plan.summary') }}</label>
                                <input required id="summary" type="text" class="form-control" name="summary"
                                       placeholder="{{ __('post_plan.summary') }}"
                                       value="{{ $post_plan->summary ?? old('summary') }}">
                                @error('summary')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('post_plan.description') }}</label>
                                <textarea id="description" type="text" class="form-control" name="description"
                                          placeholder="{{ __('post_plan.description') }}">
                                </textarea>
                                @error('description')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                <img
                                    id="previewer"
                                    src="{{$is_add ? '' : asset(@$page->image->path)}}"
                                    style="width:200px; height:200px;object-fit: contain; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;"/>
                                <input type="file" {{$is_add ? 'required':''}} name="image" id="img" accept="image/*">
                                @error('image')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right save">
                {{ __('voyager::generic.save') }}
            </button>
        </form>
    </div>
@endsection
@section('global_js')
    <script>
        const authToken = '{{Auth::user()->api_auth_token}}';
        const csrfToken = '{{ csrf_token() }}';
        const uploadApi = '{{route('api.images.upload')}}';
    </script>
@endsection
@section('js')
    <script>
        ClassicEditor.create(document.querySelector('#description'), {
            image: {
                upload: {
                    maxWidth: 800,
                    maxHeight: 600,
                }
            }
        })
            .then(editor => {
                window.bodyEditor = editor;
            });
        document.addEventListener('DOMContentLoaded', (e) => {
            const img = document.getElementById('img');
            const previewer = document.getElementById('previewer');

            img.addEventListener('change', (e) => {
                previewer.src = URL.createObjectURL(e.target.files[0]);
            })
        });
    </script>
    @if(!$is_add)
        <script>
            window.bodyEditor.setData('{!! html_entity_decode($post_plan->description) !!}')
            document.getElementById('previewer').src = '{{asset($post_plan->image)}}'
        </script>
    @endif
@endsection
