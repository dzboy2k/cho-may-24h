@extends('admin.layout.main')
@section('page_title')
    {{__($is_add ? 'categories.add_title' : 'categories.edit_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-list"></i>
        {{__('categories.edit_or_add',['attribute'=>$is_add ? __('categories.add') : __('categories.edit')])}}
    </h1>
@endsection
@section('page_content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{$is_add ? route('admin.categories.create') : route('admin.categories.edit')}}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @error('create_failed')
                    <span class="text-danger small">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        @error('error')
                        <span class="text-danger small">{{$message}}</span>
                        @enderror
                        <div class="panel-body">
                            @if(!$is_add)
                                <div class="form-group">
                                    <label for="name">{{ __('categories.id') }}</label>
                                    <input readonly id="id" type="text" class="form-control" name="id"
                                           value="{{ $category->id ?? old('id') }}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input id="name" type="text" class="form-control" name="name"
                                       placeholder="{{ __('voyager::generic.name') }}"
                                       value="{{ $category->name ?? old('name') }}">
                                @error('name')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="order">{{ __('categories.order') }}</label>
                                <input type="number" min="1" class="form-control" id="email" name="order"
                                       placeholder="{{ __('categories.order') }}"
                                       value="{{$category->order ?? old('order') }}">
                                @error('order')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('categories.slug') }}</label>
                                <input readonly id="slug" type="text" class="form-control" name="slug"
                                       placeholder="{{ __('categories.slug') }}"
                                       value="{{$category->slug ??  old('slug') }}">
                                @error('slug')
                                <span class="small text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="parent_id">{{ __('categories.parent') }}</label>
                                <select class="form-control" name="parent_id">
                                    <option value="">{{__('categories.is_parent')}}</option>
                                    @foreach($categories as $category_item)
                                        <option
                                            value="{{$category_item->id}}" {{@$category->parent_id === $category_item->id ? 'selected' : ''}}>{{$category_item->name}}</option>
                                    @endforeach
                                </select>
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
                                    src="{{$is_add ? '' : asset(@$category->image->path)}}"
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
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            const img = document.getElementById('img');
            const previewer = document.getElementById('previewer');
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');
            name.addEventListener('input', (e) => {
                slug.value = e.target.value.toSlug('-')
            });
            img.addEventListener('change', (e) => {
                previewer.src = URL.createObjectURL(e.target.files[0]);
            })
        });
    </script>
@endsection
