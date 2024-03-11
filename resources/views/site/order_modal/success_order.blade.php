<div class="modal fade" id="success_order_modal" tabindex="-1"
    aria-labelledby="success_order_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close shadow-none small" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5 class="text-primary">{{ __('post_detail.success_order') }}</h5>
                <img class="object-fit-cover mt-2" src="{{ asset('/images/success_order.svg') }}" alt="">
            </div>
            <div class="modal-footer border-0 d-flex row justify-content-center mx-1">
                <a href="{{ route('site.history.order_history.buy') }}"
                    class="btn btn-outline-primary text-uppercase">{{ __('post_detail.purchase_history') }}</a>
                <a href="{{ route('home') }}"
                    class="btn btn-primary text-uppercase">{{ __('post_detail.continue_purchase') }}</a>
            </div>
        </div>
    </div>
</div>
