<div class="row p-md-3 py-3 mx-0 w-100 bg-white my-3">
    <div class="row mx-0">
        <div class="row mx-0 p-0">
            <div class="col-8 col-md-6 p-0">
                <h1 class="fx-h4 fw-regular home-item-title">{{ $title }}</h1>
            </div>
        </div>
        @if (count($users) <= 0)
            <h6 class="fw-light text-center my-5">{{ __('message.no_user') }}</h6>
        @endif
        @foreach ($users as $user)
            <x-site.user-item-for-grid :user="$user" :mb="$mb" :xs="$xs" :sm="$sm"
                :md="$md" :lg="$lg" />
        @endforeach
    </div>
</div>
