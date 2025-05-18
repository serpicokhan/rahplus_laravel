@php
    $counterElements = getContent('counter.element', orderById: true);
@endphp
<section class="counter-section pt-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="counter-wrapper">
                    @foreach ($counterElements as $counterElement)
                        <div class="counter-item">
                            <div class="counter-item__inner">
                                <span class="counter-item__icon wow fadeInDown">
                                    <img src="{{ frontendImage('counter', @$counterElement->data_values->icon_image, '48x48') }}"
                                        alt="image">
                                </span>
                                <div class="counter-item__content">
                                    <h3 class="counter-item__number wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                        <span class="odometer"
                                            data-odometer-final="{{ @$counterElement->data_values->count }}">
                                        </span>
                                        <span>
                                            {{ __(@$counterElement->data_values->abbreviation) }}
                                        </span>
                                    </h3>
                                    <p class="counter-item__desc wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">{{ __(@$counterElement->data_values->title) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.counter-item').each(function() {
                $(this).isInViewport(function(status) {
                    if (status === 'entered') {
                        for (
                            var i = 0; i < document.querySelectorAll('.odometer').length; i++
                        ) {
                            var el = document.querySelectorAll('.odometer')[i];
                            el.innerHTML = el.getAttribute('data-odometer-final');
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
