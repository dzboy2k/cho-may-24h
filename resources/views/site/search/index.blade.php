@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary py-4">
        <div class="container mx-auto p-0 content-bounce-margin">
            <x-site.list-user-grid-container mb="6" xs="6" sm="6" md="4" lg="3"
                :users="$result['users']" title="{{ __('search.user_result_title') }}" />

            <x-site.list-page-grid-container mb="6" xs="6" sm="6" md="4" lg="3"
                :pages="$result['pages']" title="{{ __('search.page_result_title') }}" />

            <x-site.list-post-grid-container mb="6" xs="6" sm="6" md="4" lg="3"
                show-price="show" show-provider-top="show" show-support="show" show-support-limit="show" :posts="$result['posts']"
                title="{{ __('search.post_result_title') }}" />
        </div>
    </div>
@endsection
