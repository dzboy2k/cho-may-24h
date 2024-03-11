@foreach(app('menu_header') as $menu_item)
    <a class="nav-link subtitle fw-light mx-2"
       href="{{route('site.pages',['slug'=>$menu_item->slug])}}">{{$menu_item->title}}</a>
@endforeach
