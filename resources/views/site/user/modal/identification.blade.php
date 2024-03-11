@php
    $idCard = $user->idcard ?? null;
    $identifyCode = $idCard ? $idCard->identify_code : '';
    $issue = $idCard ? $idCard->issue : '';
    $address = $idCard ? $idCard->address : '';
@endphp

<div class="modal fade" id="identificationModal" tabindex="-1" aria-labelledby="identificationModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content d-flex">
            <div class="modal-header justify-content-center">
                <h4 class="modal-title text-uppercase">{{ __('edit_profile.id_card') }}
                    /{{ __('edit_profile.passport') }}
                </h4>
            </div>
            <div class="modal-body justify-content-center">
                <div class="form-group w-100 mt-3">
                    <label for="identify_code"
                           class="subtitle">{{ __('edit_profile.id_card') }}/{{ __('edit_profile.passport') }}:</label>
                    <input type="text" class="form-control fw-light border-1 border-black py-2 bg-white shadow-none"
                           aria-label="identify code" name="identify_code" id="identify_code" maxlength="12"
                           value="{{ $identifyCode }}" placeholder="{{ __('edit_profile.enter_id_card') }}"/>
                    <span class="text-danger caption error-message" id="identify-code-error"></span>
                </div>
                <div class="form-group w-100 mt-3">
                    <label for="issue" class="subtitle">{{ __('edit_profile.issue') }}:</label>
                    <input type="date" class="form-control fw-light border-1 border-black py-2 bg-white shadow-none"
                           aria-label="date of issue" name="issue" id="issue" value="{{ $issue }}"/>
                    <span class="text-danger caption error-message" id="issue-error"></span>
                </div>
                <div class="form-group w-100 mt-3">
                    <label for="address" class="subtitle">{{ __('edit_profile.place_issue') }}:</label>
                    <input type="text" name="address" id="address" aria-label="place of issue"
                           class="form-control fw-light border-1 border-black py-2 bg-white shadow-none" value="{{ $address }}"
                           placeholder="{{ __('edit_profile.enter_place_issue') }}"/>
                    <span class="text-danger caption error-message" id="address-error"></span>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="validateIdentificationModal()" class="btn btn-primary border-0 w-100"
                        id="confirmButton">{{ __('edit_profile.confirm') }}</button>
            </div>
        </div>
    </div>
</div>
