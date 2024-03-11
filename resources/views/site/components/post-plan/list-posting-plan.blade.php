    @php
        $scriptTagRegex = config('constants.SCRIPT_TAG_REGEX');
    @endphp
    <div class="container w-100 bg-white">
        <div class="row py-3 my-3 mx-auto list-post-plan">
            @if (count($plans) > 0)
                @foreach ($plans as $item)
                    @php
                        $is_reg = @$userPlan->package_id == $item->id;
                    @endphp
                    <div
                        class="col-{{ $mb }} col-lg-{{ $lg }} col-sm-{{ $sm }} col-xl-{{ $xl }} my-3 p-3 border post-plan-item">
                            <div class="posting-header">
                                <img src="{{ asset(@$item->image) }}" alt="posting-image" class="posting-header-image rounded">
                                <h4 class="pt-3 mb-0 post-plan-title fw-medium">{{ @$item->title }}</h4>
                                <p class="caption mt-0 pt-0 pb-2 text-summary">{{ @$item->summary }}</p>
                            </div>
                            <div class="posting-content">
                                <div class="posting-content-price text-black">
                                    <p class="mb-0 pb-0 text-muted subtitle fw-light">{{ __('wallet.from') }}</p>
                                    <span class="price-text posting-content-600 pt-0 mt-0">
                                        {{ number_format($item->price_per_month, 0, '.', '.') }}
                                        <span class="text-muted caption">
                                            {{ __('wallet.dm') }}/{{ __('wallet.month') }}
                                        </span>
                                    </span>
                                </div>

                                <div class="button my-2">
                                    @if ($is_reg)
                                        <a class="py-2"
                                            href="{{ route('site.post-plans.cancel_plan', ['id' => $item->id]) }}">
                                            <button class="bg-danger text-white py-2 border-0 w-100  rounded">
                                                {{ __('wallet.cancel_plan') }}
                                            </button>
                                        </a>
                                    @else
                                        <a class="py-2"
                                            href="{{ route('site.post-plans.register', ['id' => $item->id]) }}">
                                            <button class="bg-primary text-white py-2 border-0 w-100  rounded">
                                                {{ __('wallet.buy_now') }}
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="text-break">
                                {!! preg_replace($scriptTagRegex, '', html_entity_decode(@$item->description ?? '')) !!}
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
