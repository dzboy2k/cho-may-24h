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

    <link rel="icon" type="x-icon" href="{{ setting('site.favicon') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @include('site.layouts.import_css')
    @yield('css')
</head>

<body>
    <header class="mb-md-5 pb-md-5">
        @include('site.layouts.header')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('site.layouts.footer')
    </footer>
    @include('site.layouts.import_js')
    @yield('js')
    @if (Session::has('message'))
        <script>
            showToast('{{ Session::get('message')['type'] }}', '{{ __('message.notification') }}',
                '{{ Session::get('message')['content'] }}', {
                    position: 'topRight'
                });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                let scrollPosition = $(window).scrollTop();
                let logo = $('.logo-img-mobile');

                if (scrollPosition > 20) {
                    logo.addClass('d-none');
                } else {
                    logo.removeClass('d-none');
                }
            });

            $(document).on('click', function(event) {
                let profileDropdownMenu = $('#profile-dropdown-menu');
                let profileDropdownButton = $('[data-target="profile-dropdown-menu"]');

                if (!profileDropdownMenu.is(event.target) && profileDropdownMenu.has(event.target).length === 0 &&
                    !profileDropdownButton.is(event.target) && profileDropdownButton.has(event.target).length === 0) {
                    profileDropdownMenu.removeClass('c-show');
                }
            });
        });
    </script>
</body>
</html>
