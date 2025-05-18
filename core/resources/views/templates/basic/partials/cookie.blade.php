@php
    $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
@endphp
@if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
    <div class="cookies-card hide">
        <div class="cookies-card__header">
            <h4 class="cookies-card__title mb-0">@lang('This site uses cookies')</h4>
        </div>
        <p class="cookies-card__content">
            {{ __($cookie->data_values->short_desc) }}
        </p>
        <div class="cookies-card__footer">
            <a href="{{ route('cookie.policy') }}" class="cookies-card__btn-outline">@lang('View More')</a>
            <button type="button"  class="cookies-card__btn policy">@lang('Accept All')</button>
        </div>
    </div>
@endif
