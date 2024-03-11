@foreach ($items as $index => $menu_item)
    <li class="nav-item {{ $index == 2 ? 'special-button-menu-footer' : '' }}">
        <a class="nav-link" href="{{ $menu_item->route ? route($menu_item->route) : '' }}">
            <div class="d-flex flex-column align-items-center justify-content-center"
                data-target="profile-dropdown-menu">
                <i class="{{ $menu_item->icon_class }}"></i>
                <p class="overline m-0">{{ $menu_item->title }}</p>
            </div>
        </a>
    </li>
@endforeach
@if (Auth::check())
    <div class="notification-btn position-relative d-flex flex-column align-items-center justify-content-center w-auto px-0">
        <span id="count_notification_mobile" class="position-absolute notification-badge translate-middle badge bg-danger hide"></span>
        <i class="fa-regular fa-bell"></i>
        <p class="notification-title-mobile overline m-0">{{ __('notification.title') }}</p>
    </div>
@else
    <a href="{{ route('auth.login.form') }}" class="nav-link w-auto">
        <div class="d-flex flex-column align-items-center justify-content-center w-auto px-0 ">
            <i class="fa-regular fa-bell"></i>
            <p class="notification-title-mobile overline m-0">{{ __('notification.title') }}</p>
        </div>
    </a>
@endif
<div class="d-flex flex-column align-items-center justify-content-center w-auto px-0 profile-dropdown"
    data-target="profile-dropdown-menu">
    <i class="fa-regular fa-user"></i>
    <p class="overline m-0">{{ __('header.asset') }}</p>
</div>
