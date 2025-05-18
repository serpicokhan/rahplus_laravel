@php
    $workContent = getContent('how_it_work.content', true);
    $workElements = getContent('how_it_work.element', orderById: false, limit: 4);
@endphp

<section class="how-it-works  py-120 section-bg">
    <div class="custom--container container">
        <div class="section-heading">
            <h2 class="section-heading__title" data-highlight="-1,0">
                {{ __(@$workContent->data_values->heading) }}
            </h2>
            <p class="section-heading__desc"> {{ __(@$workContent->data_values->sub_heading) }} </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="htw-steps">
                    <div class="htw-step htw-step--thumb">
                        <img src="{{ getImage('assets/images/frontend/how_it_work/' . @$workContent->data_values->image, '480x565') }}"
                            alt="How It Work">
                    </div>
                    @foreach ($workElements as $key => $workElement)
                        <div class="htw-step">
                            <div class="htw-step__num">{{ $key + 1 }}</div>
                            <h5 class="htw-step__title">{{ __(@$workElement->data_values->title) }}</h5>
                            <p class="htw-step__desc">
                                {{ __(@$workElement->data_values->short_description) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
