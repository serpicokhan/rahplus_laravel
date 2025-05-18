@php
    $vechileContent = @getContent('vehicle.content', true)->data_values;
    $vehicleElements = @getContent('vehicle.element', orderById: true);
@endphp

<section class="vehicles-section pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                        {{ __(@$vechileContent->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row gy-3 align-items-center">
            @foreach ($vehicleElements as $vehicleElement)
                <div class="col-md-6">
                    <div class="vehicles-item">
                        <img src="{{ frontendImage('vehicle', @$vehicleElement->data_values->image, '672x465') }}"
                            alt="image">
                        <div class="vehicles-item__overlay wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"></div>
                        <div class="vehicles-item__content wow fadeInDown" data-wow-duration="0.6s" data-wow-delay="0.6s">
                            <h3 class="vehicles-item__title">{{ __(@$vehicleElement->data_values->title) }}</h3>
                            <a class="vehicles-item__icon" href="{{ @$vehicleElement->data_values->url }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="" height=""
                                    viewBox="0 0 40 40" fill="none">
                                    <path
                                        d="M20 3.33342C10.7952 3.33342 3.33332 10.7953 3.33332 20.0001C3.33332 29.2048 10.7952 36.6667 20 36.6667C29.2047 36.6667 36.6667 29.2048 36.6667 20.0001C36.6667 10.7953 29.2047 3.33342 20 3.33342Z"
                                        stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M13.3333 20H26.6667" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20 26.6667L26.6667 20.0001L20 13.3334" stroke="currentColor"
                                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
