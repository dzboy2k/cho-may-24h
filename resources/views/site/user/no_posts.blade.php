<div class="text-center mb-4">
    <img src="{{ asset('images/image_nothing.svg') }}" alt="nothing post" class="img-fluid">
</div>

<div class="text-center">
    @if (Auth::check() && Auth::user()->id === $user->id)
        <h5>{{ __('user_info.no_post') }}</h5>
        <a href="{{ route('post.create.form') }}" class="btn btn-primary border-0 rounded-0 mt-3">
            <i class="fa-solid fa-upload"></i>
            {{ __('user_info.post_now') }}
        </a>
    @else
        <h5>{{ __('user_info.user_no_post') }}</h5>
    @endif
</div>
