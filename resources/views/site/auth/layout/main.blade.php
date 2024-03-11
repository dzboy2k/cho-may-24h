<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', config('app.description'))">
    <meta property="og:image" content="@yield('og_image', asset('images/default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary')">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', config('app.description'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/default.jpg'))">
    <!-- Meta Tags for Other Search Engines -->
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="@yield('meta_keywords', config('app.keywords'))">
    <meta name="author" content="@yield('meta_author', config('app.author'))">
    <meta name="generator" content="Laravel">

    <link rel="canonical" href="{{ url()->current() }}">
    @include('site.layouts.import_css')
    @yield('css')
</head>
<body>
<main class="bg-white py-3">
    @yield('content')
</main>
@include('site.layouts.import_js')
@yield('js')
</body>
</html>
