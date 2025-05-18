@php
    $footerContent = @getContent('footer.content', true)->data_values;
    $contactContent = @getContent('contact_us.content', true)->data_values;
    $links = getContent('policy_pages.element', orderById: true);
    $sIcons = getContent('social_icon.element', orderById: true);
@endphp
<footer class="footer-area pb-60">
    <div class="container">
        <div class="row newslatter">
            <div class="col-xxl-6 col-lg-7">
                <h2 class="newslatter__heading">
                    {{ __(@$footerContent->heading) }}
                </h2>
            </div>
            <div class="col-xxl-6 col-lg-5">
                <form class="newslatter__form subscribe-form no-submit-loader">
                    <div class="form-group">
                        <input name="email" type="email" class="form--control" placeholder="@lang('Your email')"
                            required>
                        <button type="submit" class="newslatter__form-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="" height="" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M21.5973 2.54257C21.1299 2.03918 20.397 1.85063 19.6968 1.78314C18.9611 1.71223 18.08 1.75939 17.1313 1.88382C15.2288 2.13337 12.9302 2.71102 10.7222 3.42176C8.51281 4.13295 6.35914 4.98865 4.74626 5.80847C3.94355 6.21648 3.24734 6.62932 2.74121 7.02586C2.48919 7.22331 2.25922 7.436 2.08623 7.66237C1.92123 7.87829 1.74764 8.18549 1.75002 8.55582C1.75629 9.5279 2.41829 10.2149 3.12327 10.676C3.84284 11.1467 4.77998 11.5014 5.71161 11.7792C6.65324 12.06 7.64346 12.2776 8.49473 12.454C8.55052 12.4655 8.66203 12.4886 8.79867 12.5168C9.31323 12.6231 9.57051 12.6763 9.81237 12.6039C10.0542 12.5315 10.2402 12.3456 10.612 11.9737L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31659 15.7071 9.70711L12.2745 13.1397C11.8954 13.5188 11.7059 13.7083 11.6342 13.9543C11.5624 14.2003 11.6203 14.4614 11.736 14.9837C12.1844 17.0084 12.5738 18.6815 12.9623 19.8071C13.1892 20.4645 13.4445 21.0336 13.7678 21.4533C14.1052 21.8913 14.5642 22.2222 15.1683 22.2489C15.5444 22.2655 15.8571 22.0938 16.0715 21.9344C16.2975 21.7666 16.51 21.5414 16.7071 21.2953C17.1031 20.8005 17.5192 20.1159 17.9332 19.3247C18.7652 17.7347 19.6462 15.6028 20.3917 13.4096C21.1368 11.2173 21.7577 8.9306 22.0568 7.0301C22.206 6.0823 22.2798 5.20207 22.2388 4.46477C22.1999 3.76556 22.0509 3.03106 21.5973 2.54257Z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-xl-6 col-lg-5 col-md-6 col-sm-12">
                <div class="footer-item">
                    <div class="footer-item__logo">
                        <a href="{{ route('home') }}"> <img src="{{ siteLogo('dark') }}" alt="image"></a>
                    </div>
                    <p class="footer-item__desc">
                        {{ __(@$footerContent->short_description) }}
                    </p>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                <div class="footer-item with-menu">
                    <h5 class="footer-item__title">@lang('Company')</h5>
                    <ul class="footer-menu">
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="{{ route('home') }}">
                                <span class="text">@lang('Home')</span>
                            </a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="{{ route('blog') }}">
                                <span class="text">@lang('Blog')</span>
                            </a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="{{ route('contact') }}">
                                <span class="text">@lang('Contact')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                <div class="footer-item with-menu-two">
                    <h5 class="footer-item__title">@lang('Legal')</h5>
                    <ul class="footer-menu">
                        @foreach ($links as $link)
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('policy.pages', @$link->slug) }}">
                                    {{ __(@$link->data_values->title) }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-7 col-sm-6">
                <div class="store-buttons">
                    <a href="{{ @$footerContent->play_store_link }}" class="store-buttons__item" target="_blank">
                        <img src="{{ frontendImage('footer', @$footerContent->play_store_image, '165x48') }}"
                            alt="image">
                    </a>
                    <a href="{{ @$footerContent->app_store_link }}" class="store-buttons__item" target="_blank">
                        <img src="{{ frontendImage('footer', @$footerContent->app_store_image, '165x48') }}"
                            alt="image">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="bottom-footer py-3">
    <div class="container">
        <div class="row gy-3">
            <div class="col-md-6 col-sm-7">
                <div class="bottom-footer-text">
                    &copy; {{ date('Y') }}
                    <a href="{{ route('home') }}"> {{ gs('site_name') }}</a>.
                    @lang('All rights reserved.')
                </div>
            </div>
            <div class="col-md-6 col-sm-5">
                <ul class="social-list">
                    @foreach ($sIcons as $sIcon)
                        <li class="social-list__item">
                            <a class="social-list__link" href="{{ @$sIcon->data_values->url }}" target="_blank">
                                @php echo @$sIcon->data_values->social_icon; @endphp
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(".subscribe-form").on('submit', function(e) {
                e.preventDefault();
                const email = $(this).find('input[name="email"]').val();
                $.ajax({
                    url: "{{ route('subscribe') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            $('input[name="email"]').val('');
                            notify('success', response.message);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
