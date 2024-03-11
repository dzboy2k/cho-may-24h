@foreach($items as $menu_item)
    @foreach($menu_item->children as $nav_item)
        <a href="{{route(' ',['category'=>str_replace('/','',$nav_item->url)])}}"
           class="subtitle fw-light nav-link mx-lg-4 mx-md-2 neutral-300">
            {{$nav_item->title}}
        </a>
    @endforeach
@endforeach
