@php
    $request = request();
    $services = App\Models\Service::get();
@endphp
<form action="" id="filter-form">
    <div class="form-group">
        <label>@lang('Ride Type')</label>
        <select name="ride_type" class="form-control select2" data-minimum-results-for-search="-1">
            <option value="">@lang('All')</option>
            <option value="{{ Status::CITY_RIDE }}" @selected($request->ride_type == Status::CITY_RIDE)>@lang('City Ride')</option>
            <option value="{{ Status::INTER_CITY_RIDE }}" @selected($request->ride_type == Status::INTER_CITY_RIDE)>@lang('Intercity Ride')</option>
        </select>
    </div>
    <div class="form-group">
        <label>@lang('Service')</label>
        <select class="form-control select2" data-minimum-results-for-search="-1" name="service_id">
            <option value="">@lang('All')</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected($request->service_id == $service->id)>
                    {{ __(keyToTitle($service->name)) }}</option>
            @endforeach
        </select>
    </div>
    <x-admin.other.filter_date />
    <x-admin.other.order_by />
    <x-admin.other.per_page_record />
    <x-admin.other.filter_dropdown_btn />
</form>
