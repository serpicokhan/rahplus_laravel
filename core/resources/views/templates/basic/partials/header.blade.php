@php
    $languages = App\Models\Language::get();
    $selectLang = $languages->where('code', config('app.locale'))->first();
    $homeUrl = request()->routeIs('home') ? '' : route('home');
@endphp

<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="logo">
            </a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    @gs('multi_language')
                        <li class="nav-item d-inline-block d-lg-none">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected">
                                    <span class="thumb">
                                        <img class="flag" src="{{ $selectLang->image_src }}" alt="lang">
                                    </span>
                                    <span class="text">{{ strtoupper($selectLang->code) }}</span>
                                </div>
                                <ul class="dropdown-list">
                                    @foreach ($languages as $language)
                                        <li class="dropdown-list__item langSel" data-value="{{ $selectLang->code }}">
                                            <span class="thumb">
                                                <img class="flag" src="{{ $language->image_src }}" alt="lang">
                                            </span>
                                            <span class="text">{{ strtoupper($language->code) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endgs
                    <li class="nav-item {{ menuActive('home') }}">
                        <a class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @foreach ($pages as $page)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages', $page->slug) }}">
                                {{ __($page->name) }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item {{ menuActive('blog') }}">
                        <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item {{ menuActive('contact') }}">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                    @gs('multi_language')
                        <li class="nav-item d-lg-block d-none">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected">
                                    <span class="thumb">
                                        <img class="flag"
                                            src="{{ getImage(getFilePath('language') . '/' . $selectLang->image) }}"
                                            alt="lang">
                                    </span>
                                    <span class="text">{{ strtoupper($selectLang->code) }}</span>
                                </div>
                                <ul class="dropdown-list">
                                    @foreach ($languages as $language)
                                        <li class="dropdown-list__item langSel" data-value="{{ $language->code }}">
                                            <span class="thumb">
                                                <img class="flag" src="{{ $language->image_src }}" alt="lang">
                                            </span>
                                            <span class="text">{{ strtoupper($language->code) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endgs
                </ul>
            </div>
        </nav>
    </div>
</header>
