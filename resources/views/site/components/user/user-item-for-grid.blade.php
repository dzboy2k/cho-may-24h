<div
    class="col-{{ $mb }} col-sm-{{ $sm }} col-md-{{ $md }} col-lg-{{ $lg }} px-2 border border-light user-item-container">
    <a class="py-1 px-0 nav-link" href="{{ route('user.info', ['id' => $user->referral_code]) }}">
        <img src="{{ asset($user->avatar) }}" class="object-fit-cover w-100 user-image-grid rounded-1" />
        <h1 class="fw-medium mt-2 mb-1 user-item-title">
            {{ $user->name }}
        </h1>
        <h5 class="subtitle my-2 fw-medium text-primary">{{ __('user_info.ID') . ': ' . $user->referral_code }}</h5>
        <h5 class="subtitle mt-1 fw-medium">{{ __('user_info.phone') . ': ' . $user->phone }}</h5>
    </a>
</div>
