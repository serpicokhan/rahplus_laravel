@php
    $mobileAppContent = @getContent('mobile_app.content', true)->data_values;
    $mobileAppElements = getContent('mobile_app.element', orderById: false);
@endphp


<section class="app-section bg-img"
    data-background-image="{{ frontendImage('mobile_app', @$mobileAppContent->background_image, '1920x750') }}">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-6">
                <div class="app-content">
                    <h2 class="app-content__title text-white wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        {{ __(@$mobileAppContent->heading) }}
                    </h2>
                    <ul class="app-content__list">
                        @foreach ($mobileAppElements as $mobileAppElement)
                            <li class="app-content__list-item wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="" height=""
                                        viewBox="0 0 22 22" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.25 11C0.25 16.9371 5.06294 21.75 11 21.75C16.9371 21.75 21.75 16.9371 21.75 11C21.75 5.06294 16.9371 0.25 11 0.25C5.06294 0.25 0.25 5.06294 0.25 11ZM15.6757 7.26285C16.0828 7.63604 16.1103 8.26861 15.7372 8.67573L10.2372 14.6757C10.0528 14.8768 9.7944 14.9938 9.5217 14.9998C9.249 15.0057 8.98576 14.9 8.79289 14.7071L6.29289 12.2071C5.90237 11.8166 5.90237 11.1834 6.29289 10.7929C6.68342 10.4024 7.31658 10.4024 7.70711 10.7929L9.4686 12.5544L14.2628 7.32428C14.636 6.91716 15.2686 6.88966 15.6757 7.26285Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="text">
                                    {{ __(@$mobileAppElement->data_values->service_name) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="app-content__buttons">
                        <a href="{{ @$mobileAppContent->button_one_url }}" class="btn btn--base wow fadeInLeft" data-wow-duration="0.7s" data-wow-delay="0.7s">
                            <span class="svg-icon">
                                @php echo @$mobileAppContent->button_one_icon @endphp
                            </span>
                            <span class="text">{{ __(@$mobileAppContent->button_one_text) }}</span>
                        </a>
                        <a href="{{ @$mobileAppContent->button_two_url }}" class="btn btn--base-two wow fadeInRight" data-wow-duration="0.7s" data-wow-delay="0.7s">
                            <span class="svg-icon">
                                @php echo @$mobileAppContent->button_two_icon @endphp
                            </span>
                            <span class="text">{{ __(@$mobileAppContent->button_two_text) }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="app-thumb  wow fadeInRight" data-wow-duration="0.6s" data-wow-delay="0.6s">
                    <img src="{{ frontendImage('mobile_app', @$mobileAppContent->image, '778x658') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
