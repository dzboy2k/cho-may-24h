@extends('site.layouts.main')
@section('content')
    <div class="container-fluid bg-secondary">
        <div class="container mx-auto py-3">
            <div class="row p-3 mx-0 w-100 content-bounce-margin">
                <div class="col-12 col-md-12 px-lg-12">
                    <form class="border-0" method="POST" action="{{route('user.change_password')}}">
                        @csrf
                        <h4 class="app-headline-3">{{ __('auth.change_password') }}</h4>
                        <input type="text" name="id"
                               value="{{Auth::id()}}"
                               class="form-control shadow-none border-1 border-black py-2 fw-light hide"
                        />
                        <div class="py-2">
                            <p class="mb-2 subtitle">{{ __('auth.old_password') }}<span class="text-danger">*</span>
                            </p>
                            <input required type="password" name="old_password"
                                   class="form-control shadow-none border-1 border-black py-2 fw-light"
                                   placeholder="{{ __('auth.enter_old_password') }}"/>
                            @error('old_password')
                            <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="py-2">
                            <p class="mb-2 subtitle">{{ __('auth.new_password') }}<span class="text-danger">*</span></p>
                            <input required type="password" name="new_password"
                                   class="form-control shadow-none border-1 border-black fw-light py-2"
                                   placeholder="{{ __('auth.enter_new_password') }}"/>
                            @error('new_password')
                            <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="py-2">
                            <p class="mb-2 subtitle">{{ __('auth.enter_confirm_new_password') }}<span
                                    class="text-danger">*</span>
                            </p>
                            <input required type="password" name="new_password_confirmation"
                                   class="form-control shadow-none border-1 border-black fw-light py-2"
                                   placeholder="{{ __('auth.enter_confirm_new_password') }}"/>
                            @error('password_confirmation')
                            <span class="text-danger caption">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                                class="btn btn-primary shadow-lg w-auto border-0 py-2 text-uppercase mt-3 btn-txt">{{
                        __('auth.save_changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
