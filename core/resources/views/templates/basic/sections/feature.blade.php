@php
    $featureContent = @getContent('feature.content', true)->data_values;
    $featureElements = @getContent('feature.element', orderById: true);
@endphp

<section class="feature-section py-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                        {{ __(@$featureContent->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-lg-6">
                <div class="feature-thumb">
                    <div class="feature-thumb__item">
                        <span class="feature-thumb__icon wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.5s"><i class="fa-solid fa-arrow-right"></i></span>
                        <img class=" wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s" src="{{ frontendImage('feature', @$featureContent->image_one, '672x300') }}" alt="image">
                    </div>
                    <div class="feature-thumb__item wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        <img src="{{ frontendImage('feature', @$featureContent->image_two, '324x300') }}" alt="image">
                    </div>
                    <div class="feature-thumb__item wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        <img src="{{ frontendImage('feature', @$featureContent->image_three, '324x300') }}" alt="image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-content">
                    @foreach ($featureElements as $aboutElement)
                        <div class="feature-item">
                            <span class="feature-item__icon wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                <img src="{{ frontendImage('feature', @$aboutElement->data_values->icon_image, '32x32') }}"
                                    alt="image">
                            </span>
                            <div class="feature-item__content">
                                <h4 class="feature-item__title wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                    {{ __(@$aboutElement->data_values->heading) }}
                                </h4>
                                <p class="feature-item__desc wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                    {{ __(@$aboutElement->data_values->subheading) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
