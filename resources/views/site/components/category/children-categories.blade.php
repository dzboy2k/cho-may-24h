@foreach($categories as $category)
    @php
        $hasChildren = count($category->children) > 0;
        $is_parent =  $category->parent_id === null;
    @endphp
    @if($is_parent  || ($parentId !== null && $parentId === $category->parent_id))
        <div class="{{$hasChildren ? 'c-dropdown' : ''}} border-1 py-2  c-dropdown-item">
            <a href="{{route('post.filter',['category_id'=>$category->id])}}"
               class="nav-link d-flex align-items-center justify-content-between w-100">
                <div>
                    <img src="{{ asset(@$category->image->path) }}" class="category-menu-img" alt=""/>
                    <span class="subtitle fw-light mx-1">{{$category->name}}</span>
                </div>
                @if($hasChildren)
                    <i class="fa-regular fa-angle-down"></i>
                @endif
            </a>
            @if($hasChildren)
                <div class="dropdown-content dropdown-right">
                    <x-site.children-categories :categories="$category->children" :parent-id="$category->id"/>
                </div>
            @endif
        </div>
    @endif
@endforeach


