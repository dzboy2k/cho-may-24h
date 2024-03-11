<div class="modal fade" id="choose_payment_method" tabindex="-1"
    aria-labelledby="choose_payment_method_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close shadow-none small" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-primary">{{ __('post_detail.chose_method') }}</h5>
                <p class="text-danger caption mb-0">
                    {{ __('post_detail.note_payment') }}
                </p>
                <ul class="text-danger caption">
                    <li>{{ __('post_detail.note_payment_first') }}</li>
                    <li>{{ __('post_detail.note_payment_second') }}</li>
                </ul>
            </div>
            <div class="modal-footer border-0 d-flex row justify-content-center mx-1">
                <button id="payment-cod-btn" data-payment-cod-post-id="{{ $post->id }}" type="button"
                    class="btn btn-outline-primary text-uppercase"
                    data-bs-toggle="modal">{{ __('post_detail.payment_cod') }}</button>
                <button type="button"
                    class="btn btn-primary text-uppercase">{{ __('post_detail.payment_wallet') }}</button>
                <span class="text-center text-danger caption">{{ __('post_detail.payment_note') }}</span>
            </div>
        </div>
    </div>
</div>
