
<ul class="breadcrumb-list  {{ @$insSectionClass ?? 'in-section' }}">
    <li class="breadcrumb-list__item">
        <a href="{{ route('home') }}" class="breadcrumb-list__item-link">@lang('Home')</a>
    </li>
    <li class="breadcrumb-list__item icon"><i class="las la-angle-right"></i></li>
    <li class="breadcrumb-list__item">
        <span class="breadcrumb-list__item-text">
            {{ __($pageTitle) }}
        </span>
    </li>
</ul>
