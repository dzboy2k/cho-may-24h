@extends('admin.layout.main')
@section('page_title')
    {{__($is_add ? 'brand.add_title' : 'brand.edit_title')}}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-list"></i>
        {{__('brand.edit_or_add',['attribute'=>$is_add ? __('brand.add') : __('brand.edit')])}}
    </h1>
@endsection
@section('page_content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{$is_add ? route('admin.brands.create') : route('admin.brands.edit')}}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            @if(!$is_add)
                                <div class="form-group">
                                    <label for="name">{{ __('brands.id') }}</label>
                                    <input readonly id="id" type="text" class="form-control" name="id"
                                           value="{{ $brand->id ?? old('id') }}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input id="name" type="text" class="form-control" name="name"
                                       placeholder="{{ __('voyager::generic.name') }}"
                                       value="{{ $brand->name ?? old('name') }}">
                                @error('name')
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
                                    src="{{$is_add ? '' : asset(@$brand->image->path)}}"
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
            img.addEventListener('change', (e) => {
                previewer.src = URL.createObjectURL(e.target.files[0]);
            })
        });
    </script>
@endsection
