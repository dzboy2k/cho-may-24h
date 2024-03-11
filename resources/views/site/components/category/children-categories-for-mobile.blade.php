@foreach ($categories as $category)
    @php
        $hasChildren = count($category->children) > 0;
        $is_parent = $category->parent_id === null;
    @endphp
    @if ($is_parent || ($parentId !== null && $parentId === $category->parent_id))
        <div class="py-2 mobile-category-item">
            <div
                class="p-2 rounded btn w-100 text-start border-0 btn-mobile-behavior d-flex justify-content-between align-items-center">
                <a class="nav-link" href="{{ route('post.filter', ['category_id' => $category->id]) }}">
                    <img src="{{ asset(@$category->image->path) }}" class="category-menu-img" alt=""/>
                    <span>{{ $category->name }}</span>
                </a>
                @if ($hasChildren)
                    <span class="fa fa-angle-down" data-bs-toggle="collapse" href="#{{ $category->id }}"></span>
                @endif
            </div>
            @if ($hasChildren)
                <div id="{{ $category->id }}" class="panel-collapse collapse ms-3">
                    <x-site.children-categories-for-mobile :categories="$category->children" :parent-id="$category->id" />
                </div>
            @endif
        </div>
    @endif
@endforeach
