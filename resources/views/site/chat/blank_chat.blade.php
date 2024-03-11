<div class="container-fluid bg-secondary hide" id="blank_contact">
    <div class="container px-0 py-4 mx-auto content-bounce-margin d-flex justify-content-center align-self-center">
        <div class="col-md-12 col-lg-10 row mx-1">
            <div class="card rounded-0">
                <img src="{{ asset('/images/blank_chat.svg') }}"
                     class="object-fit-cover d-flex justify-content-center align-self-center" alt="blank chat image"
                     width="300">
                <div class="card-body text-center">
                    <span class="fw-bolder"> {{ __('chat.no_chat') }} </span>
                    <p class="caption"> {{ __('chat.no_chat_message') }} </p>
                    <a href=" {{ route('home') }} "
                       class="btn btn-txt btn-primary border-0 text-white">{{ __('chat.go_to_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
