@props(['driver', 'driverText' => false])

@if ($driver)
<div class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
        <span class="table-thumb d-none d-lg-block">
            @if (@$driver->image)
                <img src="{{ $driver->image_src }}" alt="driver">
            @else
                <span class="name-short-form">
                    {{ __(@$driver->full_name_short_form ?? 'N/A') }}
                </span>
            @endif
        </span>
        <div class="text-end text-md-start">
            <strong class="d-block">
                {{ __(@$driver->fullname) }}
            </strong>
            <a class="fs-13" href="{{ route('admin.driver.detail', $driver->id) }}">{{ @$driver->username }}</a>
            @if ($driverText)
                <br>
                <small class="fs-10">@lang('Driver')</small>
            @endif
        </div>
    </div>
@else
    <span>@lang('N/A')</span>
@endif
