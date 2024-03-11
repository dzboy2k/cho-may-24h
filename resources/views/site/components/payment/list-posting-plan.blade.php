@php
    $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
@endphp
<div class=" w-100 bg-white">
    <div class="row py-3 mx-auto my-3 d-flex list-post-plan ">
        @if (count($plans) > 0)
            @foreach ($plans as $item)
                @php
                    $is_reg = @$userPlan->package_id == $item->id;
                @endphp
                <div
                    class="col-{{ $mb }}  col-lg-{{ $lg }} col-sm-{{ $sm }} col-xl-{{ $xl }} mt-3 px-2">
                    <div class="border-1 border rounded p-4 post-plan-item">
                        <div class="posting-header">
                            <img src="{{ asset(@$item->image) }}" alt="posting-image" class="posting-header-image">
                            <h5 class="pt-3 text-truncate">{{ @$item->title }}</h5>
                            <p class="text-summary">{{ @$item->summary }}</p>

                        </div>
                        <div class="posting-content">
                            <div class="posting-content-price text-black">
                                <span class="price-text posting-content-600">{{ @$item->price }}</span>
                            </div>

                            <div class="button my-1">
                                @if ($is_reg)
                                    <a class="py-2"
                                        href="{{ route('site.post-plans.cancel_plan', ['id' => $item->id]) }}">
                                        <button class="bg-danger text-white py-2 border-0 w-100  rounded">
                                            {{ __('wallet.cancel_plan') }}
                                        </button>
                                    </a>
                                @else
                                    <div class="button my-1">
                                        <a class="py-2"
                                            href="{{ route('site.post-plans.register', ['id' => $item->id]) }}">
                                            <button class="bg-primary text-white py-2 border-0 w-100  rounded">
                                                {{ number_format($item->price_per_month, 0, '.', '.') . 'đ / Month' }}
                                            </button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="description posting-content post-description">
                            {!! preg_replace($scriptTagRegex, '', html_entity_decode(@$item->description ?? '')) !!}
                        </div>
                    </div>

                </div>
            @endforeach
        @else
            <div class="col-12 d-flex justify-content-center align-content-center">
                <p>{{ __('post_plan.no_plans') }}</p>
            </div>
        @endif
    </div>
</div>
