@extends('site.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
    @php
        $count_slides = count($slides);
        $count_suported_posts = count($supported_posts);
    @endphp
    <div class="bg-secondary pt-md-3">
        <div class="container mx-auto py-2">
            <div class="row p-md-3 mx-0 bg-white content-bounce-margin home-slides">
                <div id="home-slides" class="carousel slide px-0" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @for ($i = 0; $i < $count_slides; $i++)
                            <button type="button" data-bs-target="#home-slides" data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}" aria-current="true"
                                aria-label="Slide {{ $i }}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @for ($i = 0; $i < $count_slides; $i++)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}" data-bs-interval="3500">
                                <img class="object-fit-cover w-100 img-slide"
                                    src="{{ $slides[$i]->image !== '' ? $slides[$i]->image : asset('/images/default-slide.jpg') }}"
                                    alt="home slide">
                            </div>
                        @endfor
                    </div>
                    @if ($count_slides > 1)
                        <a class="carousel-control-prev z-0" href="#home-slides" role="button" data-bs-slide="prev"
                            aria-label="Previous Slide">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next z-0" href="#home-slides" role="button" data-bs-slide="next"
                            aria-label="Next Slide">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    @endif
                </div>
                <div class="row my-1 mx-0 w-100 px-0">
                    <div class="scroll-container-subcategory">
                        <div class="scroll-wrapper-subcategory">
                            @foreach ($sub_categories as $menu_item)
                                <a class="nav-link col-3 col-md-2 col-xl-cus-12 my-2 px-2 item-subcategory mb-2"
                                    href="{{ route('site.pages', ['slug' => $menu_item->slug]) }}">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset($menu_item->image) }}"
                                            class="rounded-circle bg-primary submenu-img object-fit-cover"
                                            alt="submenu image" />
                                        <p class="fw-medium mb-0 mt-2 text-center text-name-subcategories">
                                            {{ $menu_item->title }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <button class="subcategory-prev-btn prev-btn-scroll" aria-label="Previous Subcategory"
                            aria-hidden="false">
                            <i class="fa-solid fa-chevron-left fs-6"></i>
                        </button>
                        <button class="subcategory-next-btn next-btn-scroll" aria-label="Next Subcategory"
                            aria-hidden="false">
                            <i class="fa-solid fa-chevron-right fs-6"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row p-md-3 py-3 my-3 bg-white w-100 mx-0">
                <h1 class="fx-h4 fw-regular home-item-title">{{ __('home.explore_categories') }}</h1>
                <div class="scroll-container-category mx-1">
                    <div class="scroll-wrapper-category d-flex flex-wrap flex-column mx-0 my-2">
                        @foreach ($categories as $category)
                            @if (!$category->parent_id)
                                <a class="nav-link col-3 col-md-2 item-category my-2 me-3 me-md-0"
                                    href="{{ route('category.explode', ['slug' => str_replace('/', '', $category->slug), 'is_official' => $is_official]) }}">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ @$category->image->path }}" class="img-fluid category-image"
                                            alt="{{ @$category->image->alt }}">
                                        <h6 class="mb-0 mt-2 fw-medium text-name-category">{{ $category->name }}</h6>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <button class="category-prev-btn prev-btn-scroll" aria-label="Previous Category" aria-hidden="false">
                        <i class="fa-solid fa-chevron-left fs-6"></i>
                    </button>
                    <button class="category-next-btn next-btn-scroll" aria-label="Next Category" aria-hidden="false">
                        <i class="fa-solid fa-chevron-right fs-6"></i>
                    </button>
                </div>
            </div>
            <div class="row p-md-3 py-3 mx-0 w-100 bg-white my-3">
                <div class="row mx-0 p-0">
                    <div class="col-lg-10 col-xl-4 col-md-9 col-12 col-sm-9">
                        <h1 class="fx-h4 fw-regular text-danger home-item-title">{{ __('home.supported_product') }}</h1>
                    </div>
                    @if ($count_suported_posts > 0)
                        <div class="col-0 d-none d-md-flex col-xl-7 col-lg-0 col-md-0 d-lg-none d-xl-flex d-md-none mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fa-regular text-danger fa-shield-check"></i>
                                <span class="subtitle ms-2">{{ __('home.auth_product') }}</span>
                            </div>
                            <div class="d-flex align-items-center mx-3">
                                <i class="fa-regular text-danger fa-truck-fast"></i>
                                <span class="subtitle ms-2">{{ __('home.free_ship') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-regular text-danger fa-arrow-rotate-left"></i>
                                <span class="subtitle ms-2">{{ __('home.return_product') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row mx-0">
                    @if ($count_suported_posts <= 0)
                        <h6 class="fw-light text-center my-5">{{ __('message.no_post') }}</h6>
                    @endif
                    @foreach ($supported_posts as $post)
                        <x-site.post-item-for-gird :post="$post" mb="6" xs="6" sm="6"
                            md="4" lg="3" price="show" support="show" provider-top="show"
                            limit="show" />
                    @endforeach
                </div>
                @if ($count_suported_posts > 0)
                    <div class="col-12 col-md-12 d-flex justify-content-center mt-2">
                        <a class="subtitle text-center text-black"
                            href="{{ route('category.explode', ['slug' => 'supported_posts', 'is_official' => $is_official]) }}">{{ __('home.see_more') }}</a>
                    </div>
                @endif
            </div>
            <x-site.list-post-grid-container mb="6" xs="6" sm="6" md="4" lg="3"
                show-price="show" show-provider-top="show" show-support="show" show-support-limit="show"
                view-more-link="{{ route('category.explode', ['slug' => 'recent-posts', 'is_official' => $is_official]) }}"
                :posts="$recent_posts" :title="__('home.recent_post')" />
            @foreach ($posts_by_categories as $category)
                <x-site.list-post-grid-container mb="6" xs="6" sm="6" md="4"
                    lg="3" show-price="show" show-provider-top="show" show-support="show"
                    show-support-limit="show"
                    view-more-link="{{ route('category.explode', ['slug' => $category['slug'], 'is_official' => $is_official]) }}"
                    :posts="$category['items']" :title="__('home.posts_category', ['name' => strtolower($category['title'])])" />
            @endforeach
        </div>
    </div>
@endsection
@section('js')
    <script src="js/scrollHorizontally.js"></script>
    <script>
        $(document).ready(function() {
            const prevCategoryBtn = document.querySelector('.category-prev-btn');
            const nextCategoryBtn = document.querySelector('.category-next-btn');
            const scrollContainerCategory = document.querySelector('.scroll-wrapper-category');

            const scrollLeft = scrollContainerCategory.scrollLeft;
            prevCategoryBtn.addEventListener('click', () => {
                scrollContainerCategory.scrollLeft -= 200;
                scrollContainerCategory.style.transition = 'transform 0.3s ease';
                scrollContainerCategory.style.transform = 'transform .2s';
            });

            nextCategoryBtn.addEventListener('click', () => {
                scrollContainerCategory.scrollLeft += 200;
                scrollContainerCategory.style.transition = 'transform 0.3s ease';
                scrollContainerCategory.style.transform = 'transform .2s';
            });

            scrollHorizontally('.scroll-wrapper-subcategory', '.subcategory-prev-btn', '.subcategory-next-btn',
                '.item-subcategory');
        })
    </script>
@endsection
