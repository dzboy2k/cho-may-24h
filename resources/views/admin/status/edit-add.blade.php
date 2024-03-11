@extends('admin.layout.main')
@section('page_title')
    {{ __($is_add ? 'status.add_title' : 'status.edit_title') }}
@endsection
@section('header')
    <h1 class="page-title">
        <i class="voyager-activity"></i>
        {{ __('status.edit_or_add', ['attribute' => $is_add ? __('status.add') : __('status.edit')]) }}
    </h1>
@endsection
@section('page_content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
            action="{{ $is_add ? route('admin.status.create') : route('admin.status.edit') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            @if (!$is_add)
                                <div class="form-group">
                                    <label for="name">{{ __('status.id') }}</label>
                                    <input readonly id="id" type="text" class="form-control" name="id"
                                        value="{{ $status->id ?? old('id') }}">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">{{ __('status.name') }}</label>
                                <input id="name" type="text" class="form-control" name="name"
                                    placeholder="{{ __('status.name') }}" value="{{ $status->name ?? old('name') }}">
                                @error('name')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="type">{{ __('status.type') }}</label>
                                <select name="type" class="form-control">
                                    @foreach (config('constants.STATUS_TYPES') as $status_title => $status_type)
                                        <option value="{{ $status_type }}" {{ @$status->type == $status_type ? 'selected' : '' }}>
                                            {{ $status_type == 0 ? __('status.post') : __('status.page') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class="small text-danger">{{ $message }}</span>
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
