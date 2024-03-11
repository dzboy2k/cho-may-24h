@extends('admin.layout.main')
@section('page_title')
    {{__($is_add ? 'page.add_title' : 'page.edit_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-documentation"></i>
        {{__('page.edit_or_add',['attributes'=>$is_add ? __('page.add') : __('page.edit')])}}
    </h1>
@endsection
@section('page_content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{$is_add ? route('admin.pages.create') : route('admin.pages.edit')}}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            @if(!$is_add)
                                <div class="form-group">
                                    <label for="name">{{ __('page.id') }}</label>
                                    <input readonly id="id" type="text" class="form-control" name="id"
                                           value="{{ $page->id ?? old('id') }}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="title">{{ __('page.title') }}</label>
                                <input id="title" type="text" class="form-control" name="title"
                                       placeholder="{{ __('page.title') }}"
                                       value="{{ @$page->title ?? old('title') }}">
                                @error('title')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('post.slug') }}</label>
                                <input id="slug" type="text" class="form-control" name="slug"
                                       placeholder="{{ __('post.slug') }}"
                                       value="{{ @$page->slug ?? old('slug') }}">
                                @error('slug')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="body">{{ __('page.body') }}</label>
                                <textarea type="text" class="page-body" name="body" id="body"></textarea>
                                @error('body')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meta_desc">{{ __('page.meta_desc') }}</label>
                                <textarea class="form-control" style="max-width: 100%;" name="meta_description"
                                          placeholder="{{ __('page.meta_desc') }}"></textarea>
                                @error('meta_description')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">{{ __('page.status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="ACTIVE">{{__('page.active')}}</option>
                                    <option value="INACTIVE">{{__('page.inactive')}}</option>
                                </select>
                                @error('status')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="show_in_home_slide"
                                       class="my-0" {{@$page->show_in_home_slide == 1 ? 'checked': ''}}/>
                                <label for="show_in_home"
                                       class="mb-1">{{ __('page.show_in_home') }}</label>
                                @error('show_in_home')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox"
                                       name="is_service" {{@$page->is_service == 1? 'checked': ''}}/>
                                <label for="is_service">{{ __('page.is_service') }}</label>
                                @error('is_service')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox"
                                       name="show_in_header" {{@$page->show_in_header == 1? 'checked': ''}}/>
                                <label for="is_service">{{ __('page.show_in_header') }}</label>
                                @error('show_in_header')
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
                                    style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;"/>
                                <input type="file" name="image" id="img" accept="image/*">
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
        ClassicEditor.create(document.querySelector('#body'), {
            extraPlugins: [ImageUploaderPlugin],
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
            document.getElementById('title').addEventListener('input', (e) => {
                document.getElementById('slug').value = e.target.value.toSlug('-');
            });
            img.addEventListener('change', (e) => {
                previewer.src = URL.createObjectURL(e.target.files[0]);
            })
        });
    </script>
    @if(!$is_add)
        <script>
            window.bodyEditor.setData('{!! html_entity_decode($page->body) !!}')
            document.getElementById('previewer').src = '{{asset($page->image)}}'
        </script>
    @endif
@endsection
