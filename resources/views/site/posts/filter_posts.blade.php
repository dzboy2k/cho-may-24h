@extends('site.layouts.main')
@section('content')
    <div class="container-fluid px-0 bg-secondary">
        <div class="container mx-auto py-3 px-0 content-bounce-margin">
            <form method="get" action="{{ route('post.filter') }}" class="form-control rounded-0 border-0 py-3 w-100">
                @csrf
                <div class="row">
                    <h4 class="mb-4">{{ __('post_filter.filter') }}</h4>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <select name="category_id" class="form-select shadow-none border-1 border-black">
                            <option selected value="">{{__('post_filter.catelogy')}}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @if ($category->id == ($select_data['category_id'] ?? -1)) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                            <span class="select-icon">&#9660;</span>
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <select name="brand_id" class="form-select shadow-none border-1 border-black">
                            <option selected value="">{{__('post_filter.brand')}}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                        @if ($brand->id == ($select_data['brand_id'] ?? -1)) selected @endif>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        @php
                            $prices = config('constants.POST_PRICE');
                        @endphp
                        <select name="price" class="form-select shadow-none border-1 border-black">
                            <option selected value="">{{__('post_filter.price')}}</option>
                            @foreach ($prices as $price)
                                <option value="{{ $price['min'] }},{{ $price['max'] }}"
                                        @if ($price['min'] == (isset($select_data['price']) ? $select_data['price'][0] : -1)) selected @endif>{{ $price['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <select name="status_id" class="form-select shadow-none border-1 border-black">
                            <option selected value="">{{__('post_filter.status')}}</option>
                            @foreach ($status as $st)
                                <option value="{{ $st->id }}"
                                        @if ($st->id == ($select_data['status_id'] ?? -1)) selected @endif>
                                    {{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <select name="sort_by" class="form-select shadow-none border-1 border-black">
                            <option selected value="price">{{__('post_filter.sort_by')}}</option>
                            @foreach (config('constants.POST_SORT_BY') as $sort_by)
                                <option value="{{ $sort_by['name'] }}"
                                        @if ($sort_by['name'] == ($select_data['sort_by'] ?? -1)) selected @endif>
                                    {{ $sort_by['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <select name="sort_type" class="form-select shadow-none border-1 border-black">
                            <option selected value="ASC">{{__('post_filter.sort_type')}}</option>
                            @foreach (config('constants.POST_SORT_TYPE') as $sort_type)
                                <option value="{{ $sort_type['type'] }}"
                                        @if ($sort_type['type'] == ($select_data['sort_type'] ?? -1)) selected @endif>
                                    {{ $sort_type['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 my-1">
                        <button class="btn btn-primary w-100 border-0">{{ __('post_filter.filter') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container mx-auto py-3 px-0">
            @if($postByFilter->count() <= 0)
                <div class="bg-white p-2 py-4 d-flex justify-content-center align-items-center">
                    <p class="p-0 m-0">{{__('post_filter.no_post')}}</p>
                </div>
            @endif
            @foreach ($postByFilter as $post)
                <x-site.post-item-for-list type="list" :post="$post"></x-site.post-item-for-list>
            @endforeach
            <div class="d-flex justify-content-center mt-2">
                {{ $postByFilter->links('site.components.pagination.pagination') }}
            </div>
        </div>
    </div>
@endsection
