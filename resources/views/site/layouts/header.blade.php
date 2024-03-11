<div class="container-fluid d-none d-md-flex fixed-top bg-white header-container">
    <div class="container mx-auto">
        <div class="row py-1 align-items-center">
            <div class="col-md-3 col-lg-2 d-none d-md-flex">
                <a href="{{ route('home') }}">
                    <img class="img-fluid object-fit-contain logo-image" alt="logo" src="{{ asset(setting('site.logo')) }}" />
                </a>
            </div>
            <div class="col-md-5 col-lg-6 d-flex flex-wrap align-items-center">
                @include('menu.site_header_menu')
            </div>
            <div class="col-md-4 col-lg-4">
                @include('site.components.search.header_search')
            </div>
        </div>
        @include('site.navs.navs')
    </div>
</div>
@include('site.components.notification.list')
{{-- mobile header --}}
<div class="container-fluid mx-auto d-md-none d-flex fixed-top bg-white shadow-lg header-container-mobile">
    <div class="container">
        <div class="d-flex justify-content-center mt-1 logo-img-mobile">
            <a href="{{ route('home') }}">
                <img class="img-fluid object-fit-contain logo-image" alt="logo" src="{{ asset(setting('site.logo')) }}" />
            </a>
        </div>
        <div class="row w-100 mx-auto py-2 align-items-center">
            <div class="col-9 col-sm-10">
                @include('site.components.search.header_search')
            </div>
            <div class="col-3 col-sm-2 text-center px-0 d-flex justify-content-end">
                <a href="{{ route('chat') }}"
                        class="nav-item icon-chat-padding rounded-circle ms-2 position-relative bg-primary">
                       <i class="fa-solid fa-comments text-white"></i>
                </a>
                <button data-bs-toggle="offcanvas" href="#main_nav"
                    class="btn bg-primary border-0 rounded-circle ms-1 p-2 bg-neutral-100 d-flex justify-content-center align-items-center">
                    <img class="object-fit-contain icon" height="22" src="{{ asset('images/mobile_menu.svg') }}"
                        alt="menu-image" />
                </button>
                @include('site.components.menu.mobile')
            </div>
        </div>
    </div>
</div>
<div id="profile-dropdown-menu" class="dropdown-menu mx-auto mt-md-2 py-0 bg-secondary c-dropdown-menu-container">
    @include('site.components.user.profile')
</div>
