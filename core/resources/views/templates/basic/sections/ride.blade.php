@php
    $rideContent = @getContent('ride.content', true)->data_values;
    $rideElements = @getContent('ride.element', orderById: true);
@endphp

<section class="working-process-section pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                        {{ __(@$rideContent->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-lg-6 d-lg-block d-none">
                <div class="working-process-thumb wow fadeInLeft" data-wow-duration="0.4s" data-wow-delay="0.5s">
                    <img src="{{ frontendImage('ride', @$rideContent->image, '896x811') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                @foreach ($rideElements as $rideElement)
                    <div class="working-process-item">
                        <span class="working-process-item__number wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                            {{ $loop->iteration }}
                        </span>
                        <div class="working-process-item__content">
                            <h3 class="working-process-item__title wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                {{ __(@$rideElement->data_values->heading) }}
                            </h3>
                            <p class="working-process-item__desc wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                {{ __(@$rideElement->data_values->subheading) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
