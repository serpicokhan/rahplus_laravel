@php
    $bannerContent = @getContent('banner.content', true)->data_values;
@endphp
<section class="banner-section bg-img"
    data-background-image="{{ frontendImage('banner', @$bannerContent->background_image) }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10">
                <div class="banner-content text-center">
                    <h1 class="banner-content__title wow pulse">
                        {{ __(@$bannerContent->heading) }}
                    </h1>
                    <div class="banner-content__buttons">
                        <a href="{{ @$bannerContent->button_one_link }}" class="btn btn--base wow fadeInLeft">
                            @php echo $bannerContent->button_one_icon @endphp
                            <span class="text">{{ __(@$bannerContent->button_one_text) }}</span>
                        </a>
                        <a href="{{ @$bannerContent->button_two_link }}" class="btn btn--base-two wow fadeInRight">
                            @php echo $bannerContent->button_two_icon @endphp
                            <span class="text">{{ __(@$bannerContent->button_two_text) }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-10">
                <div class="banner-thumb wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <img src="{{ frontendImage('banner', @$bannerContent->image) }}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
