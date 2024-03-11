<div class="row p-md-3 py-3 mx-0 w-100 bg-white my-3">
    <div class="row mx-0">
        <div class="row mx-0 p-0">
            <div class="col-8 col-md-6 p-0">
                <h1 class="fx-h4 fw-regular home-item-title">{{ $title }}</h1>
            </div>
        </div>
        @if (count($posts) <= 0)
            <h6 class="fw-light text-center my-5">{{ __('message.no_post') }}</h6>
        @endif
        @foreach ($posts as $post)
            <x-site.post-item-for-gird :post="$post" :mb="$mb" :xs="$xs" :sm="$sm"
                :md="$md" :lg="$lg" :price="$showPrice" :support="$post->receive_support > 0 ? 'show' : 'hide'" :provider-top="$post->is_partner ? 'show' : 'hide'"
                :limit="$post->receive_support > 0 ? 'show' : 'hide'" :tine="$showTime" :address="$showAddress" :provider="$showProvider" />
        @endforeach
    </div>
    @if (@$viewMoreLink)
        <div class="col-12 col-md-12 d-flex justify-content-center mt-2">
            <a class="subtitle text-center text-black" href="{{ $viewMoreLink }}">{{ __('home.see_more') }}</a>
        </div>
    @endif
</div>
