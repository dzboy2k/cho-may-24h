@extends('site.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container px-0 mx-auto py-2 content-bounce-margin">
            <div class="row p-0 m-0 justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <form method="post" action="{{ route('profile.edit') }}" enctype="multipart/form-data"
                        id="form-edit-profile">
                        @csrf
                        @method('PUT')
                        <h4 class="my-4 fs-4">{{ __('edit_profile.profile') }}</h4>
                        <p class="subtitle">{{ __('edit_profile.avt') }}</p>
                        <div class="d-flex my-3">
                            <div class="py-2 d-flex w-100">
                                <img src="{{ asset($user->avatar) }}" id="uploader-preview"
                                    class="object-fit-cover rounded-circle me-4 img-fluid avt">
                                <div id="uploader"
                                    class="d-flex flex-column py-3 justify-content-center align-items-center border-1 border-black rounded bg-white w-100 uploader">
                                    <img src="{{ asset('images/upload.svg') }}" alt="upload-icon"
                                        class="object-fit-cover rounded-circle">
                                    <p class="caption text-center my-3">{{ __('edit_profile.avt_uploader_desc') }}</p>
                                    <input name="avatar" type="file" id="input-upload" class="hide"
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="row">
                                <div class="form-group col-md-6 mb-3 mb-md-0">
                                    <label for="name" class="subtitle">{{ __('edit_profile.name') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control fw-light border-1 border-black py-2 bg-white shadow-none"
                                        value="{{ $user->name }}" placeholder="{{ __('edit_profile.enter_name') }}" />
                                    @error('name')
                                        <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="subtitle">{{ __('edit_profile.phone') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="phone" id="phone"
                                        class="form-control fw-light border-1 border-black py-2 bg-white shadow-none"
                                        value="{{ $user->phone }}" placeholder="{{ __('edit_profile.enter_phone') }}"
                                        readonly />
                                    @error('phone')
                                        <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group w-100 my-3">
                            <label for="addressSelect" class="subtitle">{{ __('edit_profile.address') }}</label>
                            @php
                                $addresses = $user->addresses()->get();
                                //NOTE: so far, each user just has single address, so that we just need to get index 0 of addresses
                                $current_address = @$addresses[0];
                            @endphp
                            <input type="text" id="addressSelect" name="full_address" readonly
                                class="form-control fw-light border-1 border-black py-2 bg-white d-flex justify-content-left shadow-none"
                                onclick="showModifyAddressModal()" value="{{ @$current_address->full_address }}"
                                placeholder="{{ __('edit_profile.enter_address') }}" />
                        </div>
                        <div class="form-group w-100 my-3">
                            <label for="introduce" class="subtitle">{{ __('edit_profile.introduce') }}</label>
                            <textarea class="form-control subtitle fw-light border-1 border-black py-2 bg-white shadow-none" rows="4"
                                type="text" name="introduce" id="introduce" placeholder="{{ __('edit_profile.enter_intro') }}">{{ $user->introduce }}</textarea>
                            @error('introduce')
                                <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        </div>
                        <span class="mt-4 h4">{{ __('edit_profile.security_info') }}</span>
                        <div class="form-group w-100 my-3">
                            <label for="email" class="subtitle">{{ __('edit_profile.email') }}<span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" id="email"
                                class="form-control fw-light border-1 border-black py-2 bg-white shadow-none"
                                value="{{ $user->email }}" placeholder="{{ __('edit_profile.enter_email') }}" />
                            @error('email')
                                <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-3">
                            <div class="row">
                                <div class="form-group col-md-6 mb-3 mb-md-0">
                                    <label class="subtitle">{{ __('edit_profile.gender') }}</label>
                                    <select class="form-select fw-light border-1 border-black py-2 bg-white shadow-none"
                                        aria-label="select gender" name="gender" id="gender">
                                        <option value="">{{ __('edit_profile.choose') }}</option>
                                        @foreach (config('constants.GENDERS') as $key => $value)
                                            <option value="{{ $value }}"
                                                {{ $user->gender === $value ? 'selected' : '' }}>
                                                {{ __('genders.' . $key) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dob" class="subtitle">{{ __('edit_profile.birthday') }}</label>
                                    <input type="date" name="dob" id="dob" value="{{ $user->dob }}"
                                        class="form-control fw-light border-1 border-black py-2 bg-white shadow-none" />
                                    @error('dob')
                                        <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group w-100 my-3">
                            <label for="idCardSelect" class="subtitle">{{ __('edit_profile.id_card') }}
                                /{{ __('edit_profile.passport') }}</label>
                            @php
                                $idCard = $user->idcard;
                                $idCardValue = $idCard
                                    ? collect([$idCard->identify_code, $idCard->issue, $idCard->address])
                                        ->filter()
                                        ->join(' - ')
                                    : '';
                            @endphp
                            <input type="text" id="idCardSelect" readonly
                                class="form-control d-flex justify-content-left fw-light border-1 border-black py-2 bg-white shadow-none"
                                value="{{ $idCardValue }}" placeholder="{{ __('edit_profile.enter_id_card') }}" />
                        </div>
                        <button type="submit" id="save-button"
                            class="btn btn-primary btn-txt rounded-1 border-primary px-5 p-2 my-4 save-button">
                            {{ __('edit_profile.save_changes') }}
                        </button>
                        @include('site.user.modal.address')
                        @include('site.user.modal.identification')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/address.js') }}"></script>
    <script>
        const currentAddress = @json(@$current_address);
        const buttonSave = document.getElementById('save-button');
        const form = document.getElementById('form-edit-profile');
        const name = document.getElementById('name');
        const dob = document.getElementById('dob');
        const currentDate = new Date();
        const idCardSelect = document.getElementById('idCardSelect');
        const uploader = document.getElementById('uploader');
        const uploaderInput = document.getElementById('input-upload');
        const previewAvt = document.getElementById('uploader-preview');
        const email = document.getElementById('email');

        uploader.addEventListener('click', e => uploaderInput.click())
        uploaderInput.addEventListener('change', (e) => {
            previewAvt.src = URL.createObjectURL(e.target.files[0])
        });
        const getAddressSelections = () => {
            const provinceId = currentAddress ? currentAddress.province_id : null;
            const districtId = currentAddress ? currentAddress.district_id : null;
            const wardId = currentAddress ? currentAddress.ward_id : null;
            const streetAddress = currentAddress ? currentAddress.street_address : null;

            getProvinces(baseURL + "?depth=1", provinceId)
                .then(() => getDistricts(provinceId ? baseURL + "p/" + provinceId + "?depth=2" : null, districtId))
                .then(() => getWards(districtId ? baseURL + "d/" + districtId + "?depth=2" : null, wardId))
                .then(() => {
                    $("#street_address").val(streetAddress);
                })
                .finally(() => {
                    buttonSave.disabled = false;
                });
        }

        const showModifyAddressModal = () => {
            openModal('#addressModal', () => {
                const $provinceSelect = $("#province");
                const $districtSelect = $("#district");

                getAddressSelections();
                $provinceSelect.change(() => {
                    getDistricts(baseURL + "p/" + $provinceSelect.val() + "?depth=2");
                });
                $districtSelect.change(() => {
                    getWards(baseURL + "d/" + $districtSelect.val() + "?depth=2");
                });
            });
        }

        function validateAddressModal() {
            const selectors = ["#ward", "#district", "#province"];
            const messages = ["Vui lòng chọn phường/xã", "Vui lòng chọn quận/huyện", "Vui lòng chọn tỉnh/thành phố"];
            const errors = selectors.map((selector, index) => {
                const value = $(selector).val();
                const errorMsg = $(selector + " + .error-message");
                errorMsg.text(value === "" ? messages[index] : "");
                return value === "";
            });

            if (!errors.includes(true)) {
                const result = selectors.map(selector => $(selector).find("option:selected").text()).join(", ");
                const streetAddress = $("#street_address").val();
                let addressSelectValue = streetAddress ? streetAddress + ", " + result : result;
                $("#addressSelect").val(addressSelectValue);
                $("#addressModal").modal('hide');
            }
        }

        function validateIdentificationModal() {
            let isFormValid = true;
            const fieldsIdentificationModal = [{
                    inputElement: document.getElementById("identify_code"),
                    errorElement: document.getElementById("identify-code-error"),
                    maxLength: 12,
                    digit: true,
                    errorMsg: "CMND/CCCD/Hộ chiếu không hợp lệ."
                },
                {
                    inputElement: document.getElementById("issue"),
                    errorElement: document.getElementById("issue-error"),
                    errorMsg: "Ngày cấp không hợp lệ."
                },
                {
                    inputElement: document.getElementById("address"),
                    errorElement: document.getElementById("address-error"),
                    maxLength: 10000,
                    errorMsg: "Nơi cấp không được ghi quá dài."
                }
            ];
            fieldsIdentificationModal.forEach(field => {
                field.errorElement.textContent = "";
                if (field.inputElement.value === "") {
                    field.errorElement.textContent = "Trường này không được để trống";
                    isFormValid = false;
                } else if (field.inputElement === issue) {
                    const issueDate = new Date(field.inputElement.value);
                    const dobDate = new Date(dob.value);
                    const minIssueDate = new Date(dobDate);
                    minIssueDate.setFullYear(minIssueDate.getFullYear() + 14);

                    if (issueDate > currentDate || issueDate <= minIssueDate) {
                        field.errorElement.textContent = field.errorMsg;
                        isFormValid = false;
                    }
                } else if (field.inputElement.value.length > field.maxLength) {
                    field.errorElement.textContent = field.errorMsg;
                    isFormValid = false;
                } else if (field?.digit && !field.inputElement.value.match(/[a-zA-Z0-9]{8,12}/)) {
                    field.errorElement.textContent =
                        'Trường này không thế chứa ký tự đặc biệt và phải từ 8 đến 12 kí tự'
                    isFormValid = false;
                }
            });

            if (isFormValid) {
                const combinedFieldValue = fieldsIdentificationModal.map(field => field.inputElement.value).join(" - ");
                $("#idCardSelect").val(combinedFieldValue);
                $("#identificationModal").modal('hide');
            }
        }

        function calculateAge(dob) {
            currentDate.setHours(0, 0, 0, 0);
            const age = currentDate.getFullYear() - dob.getFullYear();
            return age;
        }

        dob.addEventListener('change', function() {
            const dobDate = new Date(dob.value);
            if (calculateAge(dobDate) <= 14) {
                idCardSelect.value = '';
                identify_code.value = '';
                issue.value = '';
                address.value = '';
            }
        });

        idCardSelect.addEventListener('click', function() {
            const dobDate = new Date(dob.value);
            
            if (isNaN(dobDate.getTime())) {
                showToast('warning', 'Cảnh báo', 'Vui lòng nhập ngày tháng năm sinh!', {
                    position: 'topRight'
                });
                return;
            }
            if (calculateAge(dobDate) <= 14) {
                showToast('warning', 'Cảnh báo', 'Bạn chưa đủ tuổi để được cấp CMND/CCCD/Passport!', {
                    position: 'topRight'
                });
            } else {
                openModal('#identificationModal');
            }
        });

        form.addEventListener('submit', (e) => {
            let isSubmit = true;
            let errorMsg = '';
            const dobDate = new Date(dob.value);
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (name.value.trim() === '') {
                isSubmit = false;
                errorMsg = errorMsg || 'Họ tên không được bỏ trống!';
            }
            if (dobDate >= currentDate || dobDate.getFullYear() < 1900) {
                isSubmit = false;
                errorMsg = errorMsg || 'Ngày sinh không hợp lệ!';
            }
            if (email.value.trim() === '' || !emailRegex.test(email.value)) {
                isSubmit = false;
                errorMsg = errorMsg || (email.value.trim() === '' ? 'Email không được bỏ trống!' :
                    'Email không hợp lệ!');
            }
            if (!isSubmit) {
                e.preventDefault();
                showToast('warning', 'Cảnh báo', errorMsg, {
                    position: 'topRight'
                });
                return;
            }
        });

        getAddressSelections();
    </script>
@endsection
