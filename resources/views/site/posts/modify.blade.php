@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/post.css') }}'/>
@endsection
@section('content')
    @php
        $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
    @endphp
    <div class="container-fluid bg-secondary">
        <div class="container px-0 mx-auto py-4 content-bounce-margin">
            <p class="subtitle fw-light text-danger text-center">
                {!! html_entity_decode(
                    __('message.create_post_notice_message', ['link'=>
                        "<a href='".route('deposit.to-sale-limit')."'>" . __('create_post.title.upgrade_limit') . '</a>',
                    ]),
                ) !!}</p>
            <form method="post"
                  action="{{ @$is_verify ? route('admin.posts.verify') : (@$post ? route('post.update') : route('post.create')) }}"
                  enctype="multipart/form-data" id="form">
                <div class="row p-0 m-0 w-100">
                    @csrf
                    <div class="col-md-5 col-lg-4">
                        @if (@$post)
                            <input value="{{ @$post->id }}" name="id" readonly
                                   class="form-control shadow-none border-1 border-black bg-white py-2 text-danger subtitle mt-1 d-none"/>
                        @endif
                        <h4 class="my-4" id="title-images">{{ __('create_post.title.images') }}</h4>
                        @if (@$post->images)
                            <div class="carousel slide" id="post-images-preview" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @php
                                        $post_images = $post->images;
                                        $count_image = $post_images->count();
                                    @endphp
                                    @for ($i = 0; $i < $count_image; $i++)
                                        <div class="img-carousel-preview carousel-item {{ $i == 0 ? 'active' : '' }}">
                                            <img src="{{ asset($post_images[$i]->path) }}"
                                                 class="d-block w-100 h-100 object-fit-contain"
                                                 alt="{{ $post_images[$i]->alt }}">
                                        </div>
                                    @endfor
                                </div>
                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#post-images-preview"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#post-images-preview"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="text-danger">
                                {{ __('post_detail.warning_update_images') }}
                            </div>
                        @endif
                        @if (@!$is_verify)
                            <div class="upload-image-box p-3">
                                <div class="d-flex flex-wrap justify-content-center align-items-center">
                                    <div role="button" id="image-uploader-container"
                                         class="d-flex justify-content-center align-items-center flex-row preview-img">
                                        <img class="image-upload-icon p-2" src="{{ asset('images/folder-up.svg') }}"
                                             alt="uploader icon">
                                        <input id="upload-input-image" type="file" name="images[]" data-max-images="6"
                                               class="visually-hidden" id="uploader" multiple="" accept="image/*"/>
                                    </div>
                                    <p class="subtitle fw-light text-center mt-3 image-upload-note">
                                        {{ __('create_post.desc.images') }}
                                    </p>
                                    <div id="upload-previewer"
                                         class="d-flex flex-wrap justify-content-center align-items-center">
                                    </div>
                                </div>
                            </div>
                            @error('images')
                            <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                            @error('images.*')
                            <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        @endif
                        <div class="mt-4 mb-1">
                            <div class="my-2">
                                <label class="subtitle">{{ __('create_post.title.price') }}<span
                                        class="text-danger">*</span></label>
                                <input {{ @$is_verify ? 'readonly' : '' }}
                                       value="{{ old('price', @number_format((@$post->price ?? 0), 0,'.','.')) }} đ"
                                       id="post-price" name="price"
                                       class="form-control shadow-none border-1 border-black bg-white py-2 text-danger subtitle mt-1"
                                       required/>
                                @error('price')
                                <span class="text-danger caption">{{ $message }}</span>
                                @enderror
                            </div>
                            {{--                            NOTE  : this code block will use when customer needed --}}
                            {{--                            <div class="bg-secondary my-2"> --}}
                            {{--                                <label class="subtitle">{{ __('create_post.title.support_percent') }}<span --}}
                            {{--                                        class="text-danger">*</span></label> --}}
                            {{--                                <input --}}
                            {{--                                    {{@$is_verify ? 'readonly' : ''}} value="{{@$is_verify ? number_format(@$post->support_limit,0,'.','.') : '0'}} %" --}}
                            {{--                                    name="support_limit" id="post-support-limit-percent" --}}
                            {{--                                    class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1" --}}
                            {{--                                    required/> --}}
                            {{--                                @error('support_limit') --}}
                            {{--                                <span class="text-danger caption">{{ $message }}</span> --}}
                            {{--                                @enderror --}}
                            {{--                            </div> --}}

                            <div class="bg-secondary my-2">
                                <label class="subtitle">{{ __('create_post.title.support_limit') }}</label>
                                <input {{ @$is_verify ? 'readonly' : '' }} name="support_limit_receive"
                                       id="post-support-limit"
                                       value="{{ old('support_limit_receive', @number_format((@$post->receive_support ?? 0), 0,'.','.')) }} đ"
                                       class="form-control shadow-none border-1 border-black py-2 bg-white text-danger subtitle mt-1"
                                       required/>
                                @error('support_limit_receive')
                                <span class="text-danger caption">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="bg-secondary mt-3 mb-1">
                                <label class="subtitle">{{ __('create_post.title.support_limit_time') }}</label>
                                <select class="form-select border-1 border-black mt-1 shadow-none" name="support_time"
                                        id="sls_max_support_month">
                                    <option value=""> {{ __('create_post.title.select') }} </option>
                                    @for ($i = 1; $i <= setting('site.max_support_time'); $i++)
                                        <option value="{{ $i }}"
                                            {{ old('support_time', @$post->expire_limit_month) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ __('post_detail.month') }}
                                        </option>
                                    @endfor
                                </select>
                                @error('support_time')
                                <span class="text-danger caption">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-100 overflow-hidden">
                            {!! html_entity_decode(setting('site.post_notice')) !!}
                        </div>
                        {{--                        <ul class="list-group subtitle fw-light text-danger list-unstyled">--}}
                        {{--                            <li>--}}
                        {{--                                <label>{{ __('create_post.desc.support_limit_note.title') }}</label>--}}
                        {{--                                <ul>--}}
                        {{--                                    <li>{{ __('create_post.desc.support_limit_note.note_1') }}</li>--}}
                        {{--                                    <li>{{ __('create_post.desc.support_limit_note.note_2') }}</li>--}}
                        {{--                                </ul>--}}
                        {{--                            </li>--}}
                        {{--                        </ul>--}}
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <div class="my-4">
                            <div class="bg-secondary mb-1">
                                <div class="my-3">
                                    <label class="subtitle">{{ __('create_post.title.category') }}<span
                                            class="text-danger">*</span></label>
                                    @if (@$is_verify)
                                        <input value="{{ @$post->category->name }}" readonly
                                               class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1"/>
                                    @else
                                        <select class="form-select border-1 border-black mt-1 shadow-none"
                                                name="category">
                                            <option value=""> {{ __('create_post.title.select') }} </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category', @$post->category->id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="bg-secondary my-3">
                                    <label class="subtitle">{{ __('create_post.title.title_of_post') }}<span
                                            class="text-danger">*</span></label>
                                    <input {{ @$is_verify ? 'readonly' : '' }}
                                           placeholder="{{ __('create_post.title.title_of_post') }}" name="title"
                                           value="{{ old('title', @$post->title) }}" type="text" id="post-title"
                                           maxlength="50"
                                           class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1"/>
                                    @error('title')
                                    <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bg-secondary my-3 input-slug">
                                    <label class="subtitle">{{ __('create_post.title.slug') }}<span
                                            class="text-danger">*</span></label>
                                    <input readonly="readonly" value="{{ old('slug', @$post->slug) }}" id="post-slug"
                                           placeholder="{{ __('create_post.title.slug') }}" name="slug" type="text"
                                           maxlength="50"
                                           class="form-control shadow-none border-1 border-black bg-neutral-200 py-2 subtitle mt-1"
                                           required/>
                                    @error('slug')
                                    <span class="text-danger caption">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- @if (!@$is_verify)
                                    <div class="bg-secondary my-3">
                                        <label class="subtitle">{{ __('create_post.title.tags') }}</label>
                                        <input placeholder="{{ __('create_post.desc.tags') }}" name="tags"
                                               type="text" id="post-tag" value="{{ old('tags') }}"
                                               class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1"/>
                                        @error('tags')
                                        <span class="text-danger caption">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="bg-secondary my-3">
                                    <label class="subtitle">{{ __('create_post.title.tags_preview') }}</label>
                                    <div
                                        class="admin-preview-item p-2 rounded bg-white d-flex flex-wrap justify-content-start align-items-start"
                                        id="tags-previewer">
                                        @if (@$is_verify)
                                            @foreach ($post->tags as $tag)
                                                <div class="tag-items caption">{{ $tag->name }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div> --}}
                                <h4 class="my-4">{{ __('create_post.title.desc_info') }}</h4>
                                <div class="my-3">
                                    <label class="subtitle">{{ __('create_post.title.status') }}<span
                                            class="text-danger">*</span></label>
                                    @if (@$is_verify)
                                        <input value="{{ @$post->status->name }}" readonly
                                               class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1"/>
                                    @else
                                        <select class="form-select border-1 border-black mt-1 shadow-none"
                                                name="status">
                                            <option value=""> {{ __('create_post.title.select') }} </option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ old('status', @$post->status->id) == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <span class="text-danger caption">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="my-3">
                                    <label class="subtitle">{{ __('create_post.title.brand') }}<span
                                            class="text-danger">*</span></label>
                                    @if (@$is_verify)
                                        <input value="{{ @$post->brand->name }}" readonly
                                               class="form-control shadow-none border-1 border-black py-2 bg-white subtitle mt-1"/>
                                    @else
                                        <select class="form-select border-1 border-black mt-1 shadow-none" name="brand">
                                            <option value=""> {{ __('create_post.title.select') }} </option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand', @$post->brand->id) == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand')
                                        <span class="text-danger caption">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="bg-secondary my-3">
                                    <label class="subtitle">{{ __('create_post.title.addition') }}</label>
                                    @if (@$is_verify)
                                        <div class="border-1 bg-white admin-preview-item p-2 rounded text-break">
                                            {!! preg_replace($scriptTagRegex, '', html_entity_decode($post->addition_info)) !!}
                                        </div>
                                    @else
                                        <textarea id="introduce_editor" name="introduce"
                                                  class="form-control shadow-none fw-light border-1 border-black py-2 bg-white subtitle mt-1"
                                                  placeholder="{{ __('create_post.title.addition') }}"></textarea>
                                        @error('introduce')
                                        <span class="text-danger caption">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="bg-secondary my-3">
                                    <label class="subtitle">{{ __('create_post.title.desc') }}<span
                                            class="text-danger">*</span></label>
                                    @if (@$is_verify)
                                        <div class="border-1 bg-white admin-preview-item p-2 rounded text-break desc">
                                            {!! preg_replace($scriptTagRegex, '', html_entity_decode($post->description)) !!}
                                        </div>
                                    @else
                                        <textarea id="description_editor" name="description"
                                                  class="form-control shadow-none fw-light border-1 border-black py-2 bg-white subtitle mt-1 desc"
                                                  placeholder="{{ __('create_post.title.desc') }}"></textarea>
                                        @error('description')
                                        <span class="text-danger caption">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="w-100 d-flex justify-content-end align-items-center">
                                    @if (@$is_verify)
                                        <button type="submit"
                                                class="btn btn-primary btn-post rounded-0 border-primary px-5 py-2">
                                            {{ __('post.verify_post') }}
                                        </button>
                                    @else
                                        <button type="button" id="btn-preview-post"
                                                class="btn btn-outline-primary mx-3 btn-post rounded-0 px-lg-5 px-3 py-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#preview_post_modal">{{ __('create_post.title.preview') }}
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary btn-post rounded-0 border-primary px-lg-5 px-3 py-2">
                                            {{ __('create_post.title.push') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="preview_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('create_post.title.post_preview') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-secondary">
                        <div class="container-fluid bg-secondary py-3">
                            <div class="container p-0 mx-auto ">
                                <div class="row">
                                    <div class="col-12 px-0">
                                        <div class="bg-white p-3 mx-3">
                                            <div id="post-images" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner" id="post_images">
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#post-images" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                        data-bs-target="#post-images" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <h4 class="my-3" id="post_title"></h4>
                                            <h5>{{ __('create_post.title.price') }}: <span class="text-danger"
                                                                                           id="post_price"></span></h5>
                                            <p class="subtitle my-1">{{ __('post_detail.support_receive') }}<span
                                                    class="text-primary" id="support_receive"></span>
                                            </p>
                                            <p class="subtitle my-1">{{ __('post_detail.support_time') }}<span
                                                    class="text-primary"
                                                    id="max_month_support">{{ __('post_detail.month') }}</span>
                                            </p>
                                        </div>
                                        <div class="bg-white p-3 my-3 mx-3">
                                            <h5>{{ __('post_detail.addition_info') }}</h5>
                                            <div class="py-2 post-addition-info text-break" id="post_addition_info">
                                            </div>
                                        </div>
                                        <div class="bg-white p-3 my-3 mx-3">
                                            <h5>{{ __('post_detail.description') }}</h5>
                                            <div class="py-2 post-description text-break" id="post_desc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@if (!@$is_verify)
    @section('js')
        <script>
            const uploadImageBox = document.querySelector('.upload-image-box');
            const imageUploadContainer = document.querySelector('#image-uploader-container');
            const imageUploadInput = document.querySelector('#upload-input-image');
            const imageUploadPreview = document.querySelector('#upload-previewer');
            const imageUploadNote = document.querySelector('.image-upload-note');
            const titleImage = document.getElementById('title-images');
            const title = document.getElementById('post-title');
            const slug = document.getElementById('post-slug');
            const form = document.getElementById('form');
            const month = document.getElementById('sls_max_support_month');
            const previewModal = document.getElementById('preview_post_modal');
            const tags = document.getElementById('post-tag');
            const tagsPreviewer = document.getElementById('tags-previewer');
            // const tagsValue = JSON.parse('@json(@$post->tags)');
            const randomString = Math.random().toString(36).substring(2, 12);
            let listImages = [];

            const previewField = {
                images: document.getElementById('post_images'),
                title: document.getElementById('post_title'),
                price: document.getElementById('post_price'),
                support_receive: document.getElementById('support_receive'),
                max_month: document.getElementById('max_month_support'),
                addition_info: document.getElementById('post_addition_info'),
                desc: document.getElementById('post_desc')
            }
            const moneyConfig = {
                numeral: true,
                prefix: ' đ',
                tailPrefix: true,
                rawValueTrimPrefix: true,
            }

            const postPrice = new Cleave('#post-price', moneyConfig);
            const postSupportLimit = new Cleave('#post-support-limit', moneyConfig);

            ClassicEditor.create(document.querySelector('#introduce_editor'), {
                extraPlugins: [ImageUploaderPlugin],
                allowedContent: {
                    script: false
                }
            })
                .then(editor => {
                    window.introduceEditor = editor;
                    editor.setData(`{!! preg_replace($scriptTagRegex, '', html_entity_decode(old('introduce', @$post->addition_info))) !!}`);
                });
            ClassicEditor.create(document.getElementById('description_editor'), {
                extraPlugins: [ImageUploaderPlugin],
                allowedContent: {
                    script: false
                }
            })
                .then(editor => {
                    window.descriptionEditor = editor;
                    editor.setData(`{!! preg_replace($scriptTagRegex, '', html_entity_decode(old('description', @$post->description))) !!}`);
                });

            function removeImage(target) {
                let fileToRemove = target.dataset.name;
                listImages = listImages.filter(item => item.name !== fileToRemove);
                updateFileList();
                renderPreviews();
                changeStylesUploadContainer();
            }

            function renderPreviews() {
                imageUploadPreview.innerHTML = '';
                listImages.forEach(file => {
                    renderImagesPreview(file, imageUploadPreview);
                });
            }

            function renderImagesPreview(file, uploadPreview) {
                let uri = URL.createObjectURL(file);
                let imgHtml =
                    `<div class="p-1">
                            <div class="preview-img position-relative">
                                <img src="${uri}" class="img-fluid w-100 square rounded object-fit-cover"/>
                                <span data-name='${file.name}' class="position-absolute small image-close-pos p-0" onclick='removeImage(this)'>&#x274c;</span>
                            </div>
                        </div>`;
                uploadPreview.innerHTML += imgHtml;
            }

            function updateFileList() {
                const newFileList = new DataTransfer();
                listImages.forEach(file => {
                    newFileList.items.add(file);
                });
                imageUploadInput.files = newFileList.files;
            }

            function changeStylesUploadContainer() {
                if (listImages.length > 0) {
                    imageUploadNote.classList.add('d-none');
                    imageUploadContainer.classList.add('image-uploader-container');
                } else {
                    imageUploadNote.classList.remove('d-none');
                    imageUploadContainer.classList.remove('image-uploader-container');
                }
            }

            imageUploadInput.addEventListener('change', function (e) {
                const maxLength = this.getAttribute('data-max-images');
                let files = e.target.files;
                let filesArr = Array.from(files);

                filesArr.forEach(function (file) {
                    if (listImages.length >= maxLength) {
                        return false;
                    } else {
                        let lengthImageArr = listImages.filter(function (item) {
                            return item !== undefined;
                        }).length;

                        if (lengthImageArr >= maxLength) {
                            return false;
                        } else {
                            listImages.push(file);
                            updateFileList();
                            renderPreviews();
                            changeStylesUploadContainer();
                        }
                    }
                });
            })

            form.addEventListener('submit', (e) => {
                let canSubmit = true;
                let errorMsg = '';
                if (imageUploadInput.files.length <= 0) {
                    canSubmit = false;
                    errorMsg = errorMsg || 'Phải có ít nhất một ảnh';
                }
                if (postPrice.getRawValue() <= 0) {
                    canSubmit = false;
                    errorMsg = errorMsg || 'Giá bán phải lớn hơn 0';
                }
                if (postSupportLimit.getRawValue() < 0) {
                    canSubmit = false;
                    errorMsg = errorMsg || 'Hạn mức hỗ trợ khấu hao phải lớn hơn hoặc bằng 0';
                }
                // if (window.introduceEditor.getData().trim() == '') {
                //     canSubmit = false;
                //     errorMsg = errorMsg || 'Giới thiệu không thể trống';
                // }
                if (window.descriptionEditor.getData().trim() == '') {
                    canSubmit = false;
                    errorMsg = errorMsg || 'Mô tả không thể trống';
                }

                if (!canSubmit) {
                    e.preventDefault();
                    showToast('error', 'Lỗi', errorMsg, {
                        position: 'topRight'
                    });
                    return;
                }
                document.getElementById('post-price').value = postPrice.getRawValue();
                document.getElementById('post-support-limit').value = postSupportLimit.getRawValue();
            })

            title.addEventListener('input', (e) => {
                let titleVal = e.target.value;
                let slugValue = titleVal.toSlug('-');
                if (slugValue) {
                    slug.value = `${slugValue}-${randomString}`;
                } else {
                    slug.value = '';
                }
            });

            // tags.addEventListener('input', (e) => {
            //     if (e.target.value.trim() == "") {
            //         tagsPreviewer.innerHTML = "";
            //         return;
            //     }
            //     const tags = e.target.value.split(',');
            //     if (tags.length > 6) {
            //         return;
            //     }
            //     renderTags(tags);
            // });
            // const renderTags = (tags) => {
            //     tagsPreviewer.innerHTML = "";
            //     for (let i = 0; i < tags.length; i++) {
            //         let tagHtml = createElement('div', {
            //             class: 'tag-items caption',
            //         })
            //         tagHtml.textContent = DOMPurify.sanitize(tags[i]);

            //         tagsPreviewer.appendChild(tagHtml);
            //     }
            // }

            previewModal.addEventListener('show.bs.modal', (e) => {
                previewField.images.innerHTML = '';
                for (let i = 0; i < imageUploadInput.files.length; i++) {
                    let url = URL.createObjectURL(imageUploadInput.files[i]);
                    let imageHtml = `
                    <div class="carousel-item ${i == 0 ? 'active' : ''}" data-bs-interval="3000">
                        <img src="${url}" class="img-carousel-preview"
                             alt="post_image">
                    </div>`;
                    previewField.images.innerHTML += imageHtml;
                }
                previewField.title.textContent = title.value;
                previewField.price.textContent = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                }).format(postPrice.getRawValue());
                previewField.support_receive.textContent = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                }).format(postSupportLimit.getRawValue());
                previewField.max_month.textContent = month.value + ' tháng';
                previewField.addition_info.innerHTML = window.introduceEditor.getData();
                previewField.desc.innerHTML = window.descriptionEditor.getData();
            });
            $(document).ready(() => {
                // if (tagsValue) {
                //     let tagsStr = tagsValue.map((val) => {
                //         return val.name;
                //     });
                //     tags.value = tagsStr.join(',');
                //     renderTags(tagsStr);
                // }
                imageUploadContainer.addEventListener('click', (e) => {
                    imageUploadInput.click();
                });
            });
        </script>
    @endsection
@endif
