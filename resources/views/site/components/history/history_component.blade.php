@php
    $headers = [];
    foreach ($listHeaderKeyLang as $index => $key) {
        $headers[$index] = __($key);
    }
@endphp
@if (empty($listHistory))
    <div class="bg-white p-3 mx-auto">
        <div class="card rounded-0 border-0">
            <div class="card-body text-center">
                <h6 class="fw-bolder"> {{ __('message.no_data') }} </h6>
                <a href=" {{ route('home') }} "
                    class="btn btn-txt btn-primary border-0 text-white mt-2">{{ __('message.go_home') }}</a>
            </div>
        </div>
    </div>
@else
    @foreach ($listHistory as $history_item)
        <div class="col-12 col-md-6 my-3">
            <div class="d-flex justify-content-center mx-md-1 p-3 bg-white h-100">
                <div class="row">
                    @foreach ($history_item as $index => $value)
                        <div class="col-5 d-flex justify-content-start py-2">
                            <span class="title_table fw-bold">{{ $headers[$index] }}:</span>
                        </div>
                        <div class="col-7 d-flex justify-content-end py-2">
                            <span class="text_table fw-light">{!! $value !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center mt-2">
        @if ($paginationRender)
            {{ $paginationRender }}
        @endif
    </div>
@endif
