@php
    $userId = Auth::id();
@endphp
@foreach ($items as $menu_item)
    @if ($menu_item->special_tag === 'title')
        <p class="subtitle my-2 bg-transparent px-3">{{ $menu_item->title }}</p>
    @else
        @if (!$userId)
            <a href="{{ route('auth.login.form') }}" class="nav-link">
                <div class="d-flex align-items-center bg-white px-3 py-1">
                    <img src="{{ asset($menu_item->icon_class) }}" class="object-fit-cover img-fluid rounded" width="24">
                    <p class="fw-light my-1 px-2">{{ $menu_item->title }}</p>
                </div>
            </a>
        @else
            <a class="nav-link" href="{{ $menu_item->route ? route($menu_item->route) : '' }}">
                <div class="d-flex align-items-center bg-white px-3 py-1">
                    <img src="{{ asset($menu_item->icon_class) }}" class="object-fit-cover img-fluid rounded" width="24">
                    <p class="fw-light my-1 px-2">{{ $menu_item->title }}</p>
                </div>
            </a>
        @endif
    @endif
@endforeach
