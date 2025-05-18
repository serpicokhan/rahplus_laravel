@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $contactContent = @getContent('contact_us.content', true)->data_values;
        $links = getContent('policy_pages.element', orderById: true);
    @endphp

    <section class="contact-section bg-img"
        data-background-image="{{ frontendImage('contact_us', @$contactContent->background_image) }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('Template::partials.breadcumb')
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-6">
                    <div class="contact-content">
                        <h1 class="contact-content__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                            {{ __($contactContent->title) }}
                        </h1>
                        <h4 class="contact-content__subtitle wow fadeInUp" data-wow-duration="0.45s" data-wow-delay="0.45s">
                            {{ __($contactContent->subtitle) }}
                        </h4>
                        <div class="contact-item-wrapper">
                            <div class="contact-item">
                                <span class="title wow fadeInUp" data-wow-duration="0.5s"
                                    data-wow-delay="0.5s">@lang('Phone')</span>
                                <a class="info wow fadeInUp" data-wow-duration="0.55s" data-wow-delay="0.55s"
                                    href="tel:{{ str_replace(' ', '', $contactContent->mobile_number) }}">
                                    {{ $contactContent->mobile_number }}
                                </a>
                            </div>
                            <div class="contact-item">
                                <span class="title wow fadeInUp" data-wow-duration="0.6s"
                                    data-wow-delay="0.6s">@lang('Email')</span>
                                <a class="info wow fadeInUp" data-wow-duration="0.65s" data-wow-delay="0.65s"
                                    href="mailto:{{ $contactContent->email }}">
                                    {{ $contactContent->email }}
                                </a>
                            </div>
                            <div class="contact-item">
                                <span class="title wow fadeInUp" data-wow-duration="0.7s"
                                    data-wow-delay="0.7s">@lang('Office')</span>
                                <span class="info wow fadeInUp" data-wow-duration="0.75s" data-wow-delay="0.75s">
                                    {{ $contactContent->location }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ $contactContent->map_link }}" target="_blank" class="contact-content__map wow fadeInUp"
                            data-wow-duration="0.8s" data-wow-delay="0.8s">
                            @lang('See on Google Map')
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M7 7H17V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7 17L17 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-xxl-6 offset-xxl-1 col-xl-7 col-lg-6">
                    <div class="contact-form">
                        <h3 class="contact-form__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                            {{ __(@$contactContent->form_title) }}
                        </h3>
                        <p class="contact-form__desc wow fadeInUp" data-wow-duration="0.45s" data-wow-delay="0.45s">
                            {{ __(@$contactContent->form_subtitle) }}
                        </p>
                        <form method="POST" class="contact-form__form verify-gcaptcha">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                        <input type="text" name="name" class="form--control"
                                            placeholder="@lang('Your name')" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group wow fadeInUp" data-wow-duration="0.55s" data-wow-delay="0.55s">
                                        <input type="text" name="email" class="form--control"
                                            placeholder="@lang('Your Email')" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                        <input type="text" name="subject" class="form--control"
                                            placeholder="@lang('Enter your subject')" value="{{ old('subject') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group wow fadeInUp" data-wow-duration="0.65s" data-wow-delay="0.65s">
                                        <textarea name="message" class="form--control" placeholder="@lang('How can we help?')" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <x-captcha/>
                                </div>
                                <div class="col-12">
                                    <div class="form-group wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.7s">
                                        <button type="submit" class="btn btn--base-two w-100">@lang('Submit')</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="contact-form__form-desc wow fadeInUp" data-wow-duration="0.75s"
                                        data-wow-delay="0.75s">
                                        @lang('By contacting us, you agree to our')
                                        @foreach ($links as $link)
                                            <a class="link" target="_blank"
                                                href="{{ route('policy.pages', @$link->slug) }}">
                                                {{ __(@$link->data_values->title) }}
                                            </a>
                                            @if (!$loop->last)
                                                <span>@lang('and')</span>
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $(".faq-section").removeClass(".py-120").addClass("pb-120 pt-60")
        })(jQuery);
    </script>
@endpush
