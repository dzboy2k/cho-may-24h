<nav class="container-fluid m-0 d-none d-md-block px-0 py-1 my-0">
    <div class="container mx-auto">
        <div class="row align-items-center">
            <div class="col-md-3 col-lg-2 ps-3">
                <div class="d-flex justify-content-start align-items-center c-dropdown">
                    <a href="#" class="nav-link d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-bars"></i>
                        <span class="subtitle mx-1">{{ __('header.categories') }}</span>
                    </a>
                    <div class="dropdown-content">
                        <x-site.children-categories :categories="app('categories')" />
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 px-1">
                <div class="d-flex justify-content-end align-items-center">
                    @php
                        $isLoggedIn = Auth::check();
                        $user = Auth::user();
                    @endphp
                    @if ($isLoggedIn)
                        <div class="position-relative ms-2">
                            <button
                                class="notification-btn nv-item bg-neutral-300 icon-padding rounded-circle border-0 bg-secondary">
                                <span id="count_notification"
                                    class="position-absolute notification-badge translate-middle badge bg-danger hide"></span>
                                <i class="fa-solid fa-bell small"></i>
                            </button>
                        </div>
                    @else
                        <a href="{{ route('auth.login.form') }}">
                            <div class="position-relative">
                                <button
                                    class="notification-btn nv-item bg-neutral-300 icon-padding rounded-circle border-0 bg-secondary">
                                    <i class="fa-solid fa-bell small"></i>
                                </button>
                            </div>
                        </a>
                    @endif
                    <a href="{{ $isLoggedIn ? route('chat') : route('auth.login.form') }}"
                        class="nav-item icon-chat-padding rounded-circle ms-2 position-relative bg-secondary">
                        <span id="chat-badge"
                            class="position-absolute chat-badge translate-middle p-2 bg-danger border border-light rounded-circle hide">
                        </span>
                       <i class="fa-solid fa-comments"></i>
                    </a>
                    <div class="dropdown-order-menu ms-2">
                        <button class="nv-item bg-neutral-300 icon-padding rounded-circle border-0 bg-secondary"
                            type="button" id="dropdown-order-menu" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdown-order-menu">
                            <li><a class="dropdown-item"
                                    href="{{ $isLoggedIn ? route('site.history.order_history.buy') : route('auth.login.form') }}">
                                    {{ __('nav.buy_order') }}
                                </a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ $isLoggedIn ? route('site.history.order_history.sell') : route('auth.login.form') }}">
                                    {{ __('nav.sell_order') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ $isLoggedIn ? route('user.info', $user->referral_code) : route('auth.login.form') }}"
                        class="nav-item d-flex align-items-center text-decoration-none icon-padding rounded ms-2 position-relative bg-secondary">
                        <i class="fa-solid fa-list"></i>
                        <div class = "caption ms-1 d-none d-lg-block"> {{__('header.posts_manager')}} </div>
                    </a>
                    <div class="dropdown ms-2">
                        <button data-target="profile-dropdown-menu"
                            class="rounded bg-secondary profile-dropdown {{ $isLoggedIn ? 'p-1' : 'user-avatar-menu' }} d-flex justify-content-center align-items-center border-0">
                            <img src="{{ $isLoggedIn ? asset(Auth::user()->avatar) : asset('images/user.svg') }}"
                                class="{{ $isLoggedIn ? 'object-fit-cover rounded-circle profile-dropdown-avatar' : 'img-fluid' }}">
                            <div class="caption ms-1 text-primary d-none d-lg-block">{{__('header.asset')}}</div>
                        </button>
                    </div>
                    <a href="{{ route('post.create.form') }}"
                        class="btn btn-primary px-3 py-2 border-0 btn-txt text-white ms-2">
                        <i class="fa-solid fa-pen-to-square"></i> {{ __('nav.push_post') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
