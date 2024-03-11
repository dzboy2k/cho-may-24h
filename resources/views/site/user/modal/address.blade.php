<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content d-flex">
            <div class="modal-header justify-content-center">
                <h4 class="modal-title text-uppercase">{{ __('edit_profile.address') }}</h4>
            </div>
            <div class="modal-body justify-content-center">
                <div class="form-group w-100 mt-2">
                    <label for="province" class="subtitle">{{ __('edit_profile.provinces') }},
                        {{ __('edit_profile.city') }}<span class="text-danger">*</span>:</label>
                    <select class="form-select fw-light border-1 border-black py-2 bg-white shadow-none"
                        aria-label="select provinces" name="province_id" id="province">
                    </select>
                    <span class="text-danger caption error-message"></span>
                </div>
                <div class="form-group w-100 mt-2">
                    <label for="district" class="subtitle">{{ __('edit_profile.district') }},
                        {{ __('edit_profile.towns') }}<span class="text-danger">*</span>:</label>
                    <select class="form-select fw-light border-1 border-black py-2 bg-white shadow-none"
                        aria-label="select district" name="district_id" id="district">
                    </select>
                    <span class="text-danger caption error-message"></span>
                </div>
                <div class="form-group w-100 mt-2">
                    <label for="ward" class="subtitle">{{ __('edit_profile.ward') }},
                        {{ __('edit_profile.commune') }}<span class="text-danger">*</span>:</label>
                    <select class="form-select fw-light border-1 border-black py-2 bg-white shadow-none" aria-label="select ward"
                        name="ward_id" id="ward">
                    </select>
                    <span class="text-danger caption error-message"></span>
                </div>
                <div class="form-group w-100 mt-2">
                    <label for="street_address" class="subtitle">{{ __('edit_profile.street_address') }}:</label>
                    <input type="text" name="street_address" id="street_address"
                        class="form-control fw-light border-1 border-black py-2 bg-white shadow-none" />
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary border-0 w-100"
                    onclick="validateAddressModal()">{{ __('edit_profile.confirm') }}</button>
            </div>
        </div>
    </div>
</div>
