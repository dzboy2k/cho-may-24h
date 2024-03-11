@extends('site.layouts.main')
@section('title',$page->title)
@section('meta_description',$page->meta_description)
@section('css')
    <link rel="stylesheet" href="{{asset('css/page.css')}}"/>
@endsection
@section('content')
    <div class="container-md mx-auto p-2 content-bounce-margin py-lg-5 mb-md-5">
        <div class="row w-100">
            <div class="col-0 col-md-1"></div>
            <div class="col-0 col-md-10">
                <h1 class="fx-h4 fw-bold text-center">{{$page->title}}</h1>
                <p class="subtitle text-center fw-semibold text-muted my-2">{{__('page.name')}}
                    : {{\Carbon\Carbon::make($page->created_at)->format('d-m-Y-H-i-s')}}</p>
                <div class="w-100 bg-white p-3">
                    {!! html_entity_decode($page->body) !!}
                </div>
            </div>
            <div class="col-0 col-md-1"></div>
        </div>
    </div>
@endsection
