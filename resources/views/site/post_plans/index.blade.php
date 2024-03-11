@extends('site.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/list-posting-plan.css') }}" />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 mx-auto py-4 content-bounce-margin">
            <x-site.posting-plan-list :plans="$post_plans" mb="12" md="4" :user-plan="$user_plan" />
        </div>
    </div>
@endsection
