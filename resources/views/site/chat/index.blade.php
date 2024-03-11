@extends('site.layouts.main')
@section('css')
    <link rel='stylesheet' href='{{ asset('css/chat.css')}}'/>
@endsection
@section('content')
    @include('site.chat.blank_chat')
    <div class="container-fluid bg-secondary" id="chat-content">
        <div class="container px-0 py-4 mx-auto content-bounce-margin d-flex justify-content-center align-self-center">
            <div class="row m-0 w-100">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="card rounded-0">
                        <div class="card-body row">
                            <div id="loader"
                                 class="position-absolute top-0 start-0 z-2 w-100 h-100 bg-white d-flex justify-content-center align-items-center">
                                <div class="spinner-border" role="status">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-5 col-xl-4 d-none d-md-block">
                                <div class="scrollable-list-messager z-0">
                                    <div class="list-group nav nav-tabs" id="list-contact">
                                    </div>
                                </div>
                            </div>
                            {{-- Note: List of mobile messengers --}}
                            <div class="ps-0 d-md-none">
                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offListMessager"
                                     aria-labelledby="offListMessagerLabel">
                                    <div class="offcanvas-header d-flex justify-content-between">
                                        <span class="subtitle">{{ __('chat.chat_in_lang') }}</span>
                                        <button type="button" class="btn btn-close border-0" data-bs-dismiss="offcanvas"
                                                aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="scrollable-list-messager">
                                        <div class="list-group" id="list-contact-mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-lg-7 col-xl-8">
                                <div class="tab-content w-100" id="list-contact-content">

                                </div>
                                <form id="send-message-form"
                                      class="p-2 d-flex justify-content-start align-items-center pt-3">
                                    <div>
                                        <label for="image-upload">
                                            <img src="{{ asset('/images/image-upload.svg') }}"
                                                 class="object-fit-cover icon-upload-img">
                                        </label>
                                        <input type="file" id="image-upload" name="media" accept="image/*"
                                               class="d-none">
                                    </div>
                                    <div class="flex-grow-1 mx-2">
                                        <div class="border border-1 rounded">
                                            <div class="form-group">
                                            <textarea data-contact="-1" data-receiver="-1" required
                                                      class="form-control border-0 shadow-none" id="message-textarea"
                                                      style="resize: none;" rows="1"
                                                      placeholder="{{ __('chat.enter_message') }}"></textarea>
                                                <div id="image-preview-container"
                                                     class="border-0 w-100 d-flex align-items-start flex-row flex-wrap d-none px-0 mx-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a type="submit" id="btn-send" class="btn p-1 border-0">
                                        <i class="far fa-paper-plane"></i>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let listContacts = [];
        const messageInput = document.getElementById('message-textarea');
        const previewContainer = document.getElementById("image-preview-container");
        const uploader = document.getElementById("image-upload");
        const userId = {{ Auth::id() }};
        const listContactContainer = document.getElementById('list-contact');
        const listContactContentContainer = document.getElementById('list-contact-content');
        const listContactMobileContainer = document.getElementById('list-contact-mobile');
        const btnSendMessage = document.getElementById('btn-send')
        const msgInput = document.getElementById('message-textarea');
        const postData = @json(@$post);
        const newContact = @json(@$contact);
        const loader = document.getElementById('loader');
        const chatLangs = {
            profile: '{{__('chat.profile')}}',
            deleteChat: '{{__('chat.delete_chat')}}',
            canNotDelete: '{{__('chat.can_not_delete')}}',
            msgWithPost: '{{str_replace('#','\n',__('chat.msg_with_post',['title'=>@$post->title]))}}'
        }
    </script>
    <script src="{{asset('js/services/chat.js')}}"></script>
@endsection
