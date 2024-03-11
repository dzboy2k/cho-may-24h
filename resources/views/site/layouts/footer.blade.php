<div class="container-fluid">
    <div class="container mx-auto">
        <div class="col-12">
            <div class="d-flex justify-content-center mt-2 d-block d-md-none">
                <a href="{{ route('home') }}">
                    <img class="img-fluid object-fit-contain logo-image" alt="logo" src="{{ asset(setting('site.logo')) }}" />
                </a>
            </div>
        </div>
        <div class="row py-4">
            {{ menu('footer', 'site.components.menu.footer_menu') }}
            @if (setting('link.google_store') || setting('link.apple_store') || setting('link.galaxy_store'))
                <div class="col-lg-3 col-6">
                    <h5>{{ __('message.download_app') }}</h5>
                    <div class="list-group pt-1">
                        @if (setting('link.google_store'))
                            <a href="{{ setting('link.google_store') }}" class="nav-link py-1">
                                <img class="object-fit-contain" src="{{ asset('images/apple_store.svg') }}"
                                    alt="apple-store" />
                            </a>
                        @endif
                        @if (setting('link.apple_store'))
                            <a href="{{ setting('link.apple_store') }}" class="nav-link py-1">
                                <img class="object-fit-contain" src="{{ asset('images/google_play.svg') }}"
                                    alt="google-store" />
                            </a>
                        @endif
                        @if (setting('link.galaxy_store'))
                            <a href="{{ setting('link.galaxy_store') }}" class="nav-link py-1">
                                <img class="object-fit-contain" src="{{ asset('images/galaxy_store.svg') }}"
                                    alt="galaxy-store" />
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="col-lg-3 col-6">
                @if (setting('link.fanpage') || setting('link.youtube') || setting('link.tiktok'))
                    <h5>{{ __('message.link') }}</h5>
                    <div class="d-flex flex-row gap-2">
                        @if (setting('link.fanpage'))
                            <a href="{{ setting('link.fanpage') }}" class="nav-link pt-1 pb-2">
                                <img class="object-fit-contain" src="{{ asset('images/facebook-icon.svg') }}"
                                    alt="fanpage" />
                            </a>
                        @endif
                        @if (setting('link.youtube'))
                            <a href="{{ setting('link.youtube') }}" class="nav-link pt-1 pb-2">
                                <img class="object-fit-contain" src="{{ asset('images/youtube-icon.svg') }}"
                                    alt="youtube channel" />
                            </a>
                        @endif
                        @if (setting('link.tiktok'))
                            <a href="{{ setting('link.tiktok') }}" class="nav-link pt-1 pb-2">
                                <img class="object-fit-contain" src="{{ asset('images/tiktok-icon.svg') }}"
                                    alt="tiktok channel" />
                            </a>
                        @endif
                    </div>
                @endif
                @if (setting('link.certify'))
                    <h5>{{ __('message.certify') }}</h5>
                    <a href="{{ setting('link.fanpage') }}" class="nav-link pt-1 pb-2">
                        <img class="object-fit-contain" src="{{ asset('images/certify.png') }}" alt="certify"
                            width="130" height="40" />
                    </a>
                @endif
            </div>
        </div>
        <div class="text-center border-top">
            <p class="subtitle fw-light neutral-300 mt-3 mb-0 setting-description full-text px-lg-5 text-footer">
                {{ setting('site.description') }}
            </p>
            <div class="d-flex flex-column align-items-center justify-content-center w-100 my-3">
                <p class="subtitle fw-light neutral-300 my-0 mx-2 text-footer">
                    {{ __('message.address') }}{{ setting('site.location') }}</p>
                <p class="subtitle fw-light neutral-300 my-0 mx-2 text-footer">
                    {{ __('message.phone_number') }}{{ setting('site.phone') }}</p>
                <p class="subtitle fw-light neutral-300 my-0 mx-2 text-footer">
                    {{ __('message.email') }}{{ setting('site.email') }}</p>
            </div>
        </div>
        <div class="row text-center border-top copyright-container">
            <p class="subtitle fw-light neutral-300 my-3 text-footer">{{ setting('site.copyright') }}</p>
        </div>
    </div>
</div>

<div class="container-fluid bg-white fixed-bottom d-block d-md-none shadow-lg">
    <div class="d-flex justify-content-between align-items-center flex-nowrap list-unstyled border-top mb-1"
        style="height: 50px;">
        {{ menu('footer_nav_mobile', 'site.components.menu.footer_nav_mobile') }}
    </div>
</div>

@if (Auth::check())
    <script src="{{ asset('js/services/format-date.js') }}"></script>
    <script>
        const langConfigs = {
            noData: '{{ __('notification.empty_notification_list') }}',
            fetchError: '{{ __('notification.fetch_error') }}',
            loadMore: '{{ __('notification.loadMore') }}'
        }
        const notificationApis = {
            readNotification: '{{ route('api_notification_read') }}',
            listNotification: '{{ route('api_notification_list_more') }}'
        }
        const chatApis = {
            fetchNewContact: ' {{ route('api.chat.contact.new') }}',
            sendMessage: '{{ route('api.chat.send') }}',
            getContactById: '{{ route('api.chat.contact') }}' + "/",
            loadContact: '{{ route('api.chat.list_contact', ['user_id' => Auth::id()]) }}',
            loadMessage: '{{ route('api.chat.list_message', ['contact_id' => -1]) }}',
            deleteChat: '{{ route('api.chat.delete', ['contact_id' => -1]) }}',
            profile: '{{ route('user.info') }}' + "/",
            readContact: '{{ route('api.chat.contact.read', ['contact_id' => -1]) }}'
        }
        const authToken = '{{ Auth::user()->api_auth_token }}';
        const csrfToken = '{{ csrf_token() }}';
        const uploadApi = '{{ route('api.images.upload') }}';
    </script>
    <script src="{{ asset('js/services/notification.js') }}"></script>
    <script src="{{ asset('js/services/chat_addition.js') }}"></script>
    <script type="module" src="{{ asset('js/pusher8_3.min.js') }}"></script>
    <script>
        getListNotification(notificationApis.listNotification, authToken);
    </script>
    <script type="module">
        import Echo from '{{ asset('js/laravel-echo_1.15.3_echo.min.js') }}';

        const id = '{{ Auth::id() }}';

        window.Pusher = Pusher;

        const echo = new Echo({
            broadcaster: 'pusher',
            namespace: 'App.Events',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: false,
            wsHost: window.location.hostname,
            encrypted: true,
        });

        echo.channel(`notification-${id}`).listen('.notification', (data) => {
            prependContainer(data?.message)
        });
        echo.channel(`chat-${id}`).listen('.chat', async (data) => {
            try {
                let isSender = {{ Auth::id() }} === data.message.sender_id;
                let isUpdate = await updateContact(data.message);
                if (!isUpdate) {
                    renderAnMessage(isSender, data.message, $('#chat-message-' + data.message
                        .sender_id));
                    moveContactToTop(data.message.sender_id);
                }
            } catch (e) {
                document.getElementById('chat-badge').classList.remove('hide');
            }
        });
    </script>
@endif
