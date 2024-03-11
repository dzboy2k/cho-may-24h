@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container mx-auto py-3 content-bounce-margin">
            @php
                $children = $category?->children->slice(0,8);
            @endphp
            @if(@$children?->count() > 0)
                <div class="row p-3 mx-0 bg-white w-100">
                    <h4>{{ __('home.explore_vehicles',['name'=>strtolower($category->name)]) }}</h4>
                    <div class="row mx-0 my-4">
                        @foreach($children as $child)
                            <div class="col-6 col-lg-2 col-md-3 text-center">
                                <a class="nav-link" href="{{route('category.explode',['slug'=>$child->slug])}}">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset(@$child->image->path) }}" alt="{{@$child->image->alt}}"
                                             class="rounded-circle object-fit-cover" width="120" height="120">
                                        <h5 class="fw-medium mt-2">{{$child->name}}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if(@$postByCategory)
                <x-site.list-post-grid-container
                    mb="6"
                    xs="6"
                    sm="6"
                    md="4"
                    lg="3"
                    show-price="show"
                    :posts="$postByCategory"
                    :title="__('home.posts_category',['name'=>$name])"/>
                <div class="d-flex justify-content-center align-items-center w-100 py-2">
                    {{$postByCategory->withQueryString()->onEachSide(1)->links('site.components.pagination.pagination')}}
                </div>
            @endif
        </div>
    </div>
@endsection
