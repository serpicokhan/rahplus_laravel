@php
    $faqContent = getContent('faq.content', true)->data_values;
    $faqElements = getContent('faq.element', orderById: true);
    $faqs = $faqElements->chunk($faqElements->count() / 2);
@endphp

<section class="faq-section py-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                        {{ __($faqContent->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="custom--accordion accordion accordion-flush" id="accordionFlushExample">
            <div class="row">
                <div class="col-lg-6">
                    @foreach ($faqs[0] as $faq)
                        <div class="accordion-item wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                            <h6 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqAccordion{{ $faq->id }}" aria-expanded="false"
                                    aria-controls="faqAccordion{{ $faq->id }}">
                                    <span class="svg-icon">
                                    </span>
                                    <span class="text">
                                        {{ __(@$faq->data_values->question) }}
                                    </span>
                                </button>
                            </h6>
                            <div id="faqAccordion{{ $faq->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    {{ __(@$faq->data_values->answer) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-6">
                    @foreach ($faqs[1] as $rightFaq)
                        <div class="accordion-item wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.5s">
                            <h6 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqAccordion{{ $rightFaq->id }}" aria-expanded="false"
                                    aria-controls="faqAccordion{{ $rightFaq->id }}">
                                    <span class="svg-icon">
                                        {{-- <i class=" las  la-plus-circle"></i> --}}
                                    </span>
                                    <span class="text">
                                        {{ __($rightFaq->data_values->question) }}
                                    </span>
                                </button>
                            </h6>
                            <div id="faqAccordion{{ $rightFaq->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    {{ __($rightFaq->data_values->answer) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="faq-contact wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <div class="faq-contact__left">
                        <span class="thumb wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                            <img src="{{ siteFavicon() }}" alt="image">
                        </span>
                        <div class="content">
                            <h6 class="title wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                @lang('Still have questions?')</h6>
                            <p class="desc wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                                @lang("Can't find the answer you are looking for? Please chat to our friendly team. ")
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="btn btn--base-two wow fadeInRight" data-wow-duration="0.5s"
                        data-wow-delay="0.5s">@lang('Get in touch')</a>
                </div>
            </div>
        </div>
    </div>
</section>
