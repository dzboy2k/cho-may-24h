@foreach ($items as $menu_item)
    @if ($menu_item->parent_id == null && $menu_item->special_tag === 'title')
        <div class="col-lg-3 col-6">
            <h5>{{ $menu_item->title }}</h5>
            <div class="list-group pt-2">
                @foreach ($menu_item->children as $nav_item)
                    <a class="nav-link neutral-300 subtitle fw-light py-2" href="{{ $nav_item->url }}">
                        {{ $nav_item->title }}</a>
                @endforeach
            </div>
        </div>
    @endif
@endforeach
