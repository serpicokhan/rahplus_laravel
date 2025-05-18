@php
    $testimonialContent = @getContent('testimonial.content', true)->data_values;
    $testimonialElements = getContent('testimonial.element');
@endphp


<section class="testimonials pt-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                        {{ __(@$testimonialContent->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="testimonials-content">
            <div class="testimonial-item__thumb wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <img src="{{ frontendImage('testimonial', $testimonialElements->first()->data_values->client_image) }}"
                    alt="image">
            </div>
            <div class="testimonials-reviews">
                <div class="reviews-text-slider slider-for">
                    @foreach ($testimonialElements as $testimonialElement)
                        <div class="slider-content wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                            <h4 class="slider-content__title wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                {{ __(@$testimonialElement->data_values->title) }}
                            </h4>
                            <p class="testimonial-item__message wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                {{ __(@$testimonialElement->data_values->message) }}
                            </p>
                            <div class="slider-content__author">
                                <h4 class="slider-content__name wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.7s">
                                    {{ __(@$testimonialElement->data_values->name) }}
                                </h4>
                                <p class="slider-content__position wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.8s">
                                    {{ __(@$testimonialElement->data_values->designation) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="testimonials-thumbs slider-nav">
                @foreach ($testimonialElements as $item)
                    <div class="slider-slider-thumb wow fadeIn" data-wow-duration="0.8s" data-wow-delay="0.8s">
                        <img src="{{ frontendImage('testimonial', $item->data_values->client_image) }}" alt="image">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 3,
                arrows: false,
                draggable: false,
                fade: true,
                asNavFor: '.slider-nav'
            });

            $('.slider-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.slider-for',

                autoplay: false,
                dots: true,
                arrows: true,
                centerMode: 2,
                focusOnSelect: true,
                centerPadding: '10px',
                prevArrow: '<span class="icon-left"><i class="fa-solid fa-arrow-left"></i></span>',
                nextArrow: '<span class="icon-right"><i class="fa-solid fa-arrow-right"></i></span>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            arrows: false,
                            dots: false,
                        }
                    },
                    {
                        breakpoint: 991,
                        centerMode: true,
                        settings: {
                            dots: false,
                            arrows: false,
                            slidesToShow: 4,
                            centerPadding: '0px',
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            autoplay: true,
                            dots: false,
                            arrows: false,
                            slidesToShow: 3,
                            centerMode: false,
                        }
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            autoplay: true,
                            dots: false,
                            arrows: false,
                            slidesToShow: 3,
                            centerMode: false,
                        }
                    },
                    {
                        breakpoint: 425,
                        settings: {
                            autoplay: true,
                            dots: false,
                            arrows: false,
                            slidesToShow: 2,
                            centerMode: false,
                        }
                    }
                ]
            });
            const imgPlaceHolder = $('.testimonial-item__thumb img');
            const placeHolder = $('.testimonial-item__thumb');
            $('.slider-nav').on('beforeChange', function() {
                placeHolder.addClass('show');
            });
            $('.slider-nav').on('afterChange', function() {
                var dataId = $('.slick-current');
                const imgSrc = $(dataId[1]).find('img').attr('src');
                placeHolder.removeClass('show');
                imgPlaceHolder.attr('src', imgSrc);
            });
        })(jQuery);
    </script>
@endpush
