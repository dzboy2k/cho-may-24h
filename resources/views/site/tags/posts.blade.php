@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-5">
        <div class="container mx-auto p-0">
            <div class="row bg-white p-2">
                <h4 class="my-2">{{ __('message.post_by_tag', ['name' => @$tag->name]) }}</h4>
            </div>
            @if (count($postsByTag) === 0)
                <div class="row p-2 bg-white my-3">
                    <h4 class="my-0">{{ __('message.no_search_data') }}</h4>
                </div>
            @endif
            @foreach (@$postsByTag as $post)
                <x-site.post-item-for-list type="list" :post="$post"/>
            @endforeach
            {{ @$postsByTag->links() }}
        </div>
    </div>
@endsection
