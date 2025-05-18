@php
    $serviceContent  = getContent('service.content', true);
    $serviceElements = getContent('service.element', orderById: true);
@endphp
<section class="our-platform py-120">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-heading__title" data-highlight="-1,0">{{ __(@$serviceContent->data_values->heading) }}</h2>
            <p class="section-heading__desc">{{ __(@$serviceContent->data_values->sub_heading) }}</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav class="nav-horizontal">
                    <button class="nav-horizontal__btn prev"><i class="las la-angle-left"></i></button>
                    <button class="nav-horizontal__btn next"><i class="las la-angle-right"></i></button>
                    <ul class="nav nav-tabs nav-horizontal-menu" id="our-platform-tab" role="tablist">
                        @foreach (@$serviceElements as $key => $services)
                            <li class="nav-horizontal-menu__item">
                                <button class="{{ $key == 0 ? 'active' : '' }}"
                                    id="{{ @$services->data_values->name }}_tab" data-bs-toggle="tab"
                                    data-bs-target="#{{ @$services->data_values->name }}" type="button">
                                    <span class="icon">
                                        <img src="{{ getImage('assets/images/frontend/service/' . @$services->data_values->service_icon, '35x35') }}"
                                            alt="service">
                                    </span>
                                    <span class="text">{{ __(@$services->data_values->name) }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <div class="tab-content">
                    @foreach (@$serviceElements as $key => $serviceElement)
                        <div class="tab-pane {{ $key == 0 ? 'active' : '' }}"
                            id="{{ @$serviceElement->data_values->name }}">
                            <div class="our-platform__content">
                                <ul class="our-platform-list">
                                    @php echo @$serviceElement->data_values->description @endphp
                                </ul>
                                <img class="our-platform__thumb"
                                    src="{{ getImage('assets/images/frontend/service/' . @$serviceElement->data_values->service_image, '400x590') }}"
                                    alt="Service Image">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
