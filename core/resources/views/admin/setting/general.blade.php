@extends('admin.layouts.app')
@section('panel')
    @php
        $pusherConfig = gs('pusher_config');
        $operationCountry = gs('operating_country');
    @endphp

    <form method="POST" enctype="multipart/form-data">
        <x-admin.ui.card>
            <x-admin.ui.card.body>
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-sm-6 col-xxl-3">
                        <div class="form-group">
                            <label> @lang('Site Title')</label>
                            <input class="form-control" type="text" name="site_name" required value="{{ gs('site_name') }}">
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Timezone')</label>
                        <select class="  form-control select2" name="timezone">
                            @foreach ($timezones as $key => $timezone)
                                <option value="{{ @$key }}" @selected(@$key == $currentTimezone)>
                                    {{ __($timezone) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Date Format')</label>
                        <select class="form-control select2" name="date_format" data-minimum-results-for-search="-1">
                            @foreach (supportedDateFormats() as $dateFormat)
                                <option value="{{ @$dateFormat }}" @selected(gs('date_format') == $dateFormat)>
                                    {{ $dateFormat }} ({{ date($dateFormat) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Time Format')</label>
                        <select class="form-control select2" name="time_format" data-minimum-results-for-search="-1">
                            @foreach (supportedTimeFormats() as $key => $timeFormat)
                                <option value="{{ @$timeFormat }}" @selected(gs('time_format') == $timeFormat)>
                                    {{ __($timeFormat) }} ({{ date($timeFormat) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Site Primary Color')</label>
                        <div class="input-group color-input">
                            <input type="text" class="form-control colorCode" name="base_color"
                                value="{{ gs('base_color') }}">
                            <span class="input-group-text">
                                <input type='text' class="form-control colorPicker" value="{{ gs('base_color') }}">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Site Secondary Color')</label>
                        <div class="input-group color-input">
                            <input type="text" class="form-control colorCode" name="secondary_color"
                                value="{{ gs('secondary_color') }}">
                            <span class="input-group-text">
                                <input type='text' class="form-control colorPicker" value="{{ gs('secondary_color') }}">
                            </span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 col-xxl-3">
                        <div class="form-group">
                            <label>@lang('Currency')</label>
                            <input class="form-control" type="text" name="cur_text" required
                                value="{{ gs('cur_text') }}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 col-xxl-3">
                        <div class="form-group">
                            <label>@lang('Currency Symbol')</label>
                            <input class="form-control" type="text" name="cur_sym" required value="{{ gs('cur_sym') }}">
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3 ">
                        <label class="required"> @lang('Currency Showing Format')</label>
                        <select class="select2 form-control" name="currency_format" data-minimum-results-for-search="-1">
                            <option value="1" @selected(gs('currency_format') == Status::CUR_BOTH)>
                                @lang('Show Currency Text and Symbol Both')({{ gs('cur_sym') }}{{ showAmount(100, currencyFormat: false) }}
                                {{ __(gs('cur_text')) }})
                            </option>
                            <option value="2" @selected(gs('currency_format') == Status::CUR_TEXT)>
                                @lang('Show Currency Text Only')({{ showAmount(100, currencyFormat: false) }} {{ __(gs('cur_text')) }})
                            </option>
                            <option value="3" @selected(gs('currency_format') == Status::CUR_SYM)>
                                @lang('Show Currency Symbol Only')({{ gs('cur_sym') }}{{ showAmount(100, currencyFormat: false) }})
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Allow Precision')</label>
                        <select class="select2 form-control" name="allow_precision" data-minimum-results-for-search="-1">
                            @foreach (range(1, 8) as $digit)
                                <option value="{{ $digit }}" @selected(gs('allow_precision') == $digit)>
                                    {{ $digit }}
                                    @lang('Digit')({{ showAmount(100, currencyFormat: false, decimal: $digit) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label class="required"> @lang('Thousand Separator')</label>
                        <select class="select2 form-control" name="thousand_separator" data-minimum-results-for-search="-1">
                            @foreach (supportedThousandSeparator() as $k => $supportedThousandSeparator)
                                <option value="{{ $k }}" @selected(gs('thousand_separator') == $k)>
                                    {{ __($supportedThousandSeparator) }}
                                    @if ($k == 'space')
                                        ({{ showAmount(1000, currencyFormat: false, separator: ' ') }})
                                    @elseif($k == 'none')
                                        (@lang('10000'))
                                    @else
                                        ({{ showAmount(1000, currencyFormat: false, separator: $k) }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-6 col-sm-6 col-xxl-3">
                        <label> @lang('Record to Display Per Page')</label>
                        <select class="select2 form-control" name="paginate_number" data-minimum-results-for-search="-1">
                            <option value="20" @selected(gs('paginate_number') == 20)>@lang('20 items')</option>
                            <option value="50" @selected(gs('paginate_number') == 50)>@lang('50 items')</option>
                            <option value="100" @selected(gs('paginate_number') == 100)>@lang('100 items')</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>@lang('Minimum Distance for Ride')</label>
                            <div class=" input--group input-group">
                                <input class="form-control" name="min_distance" type="number" step="any"
                                    value="{{ getAmount(gs('min_distance')) }}" required min="1">
                                <span class=" input-group-text">@lang('KM')</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>
                                @lang('Free Ride Cancellation for Riders')
                                <span data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                    title="Ride cancellation is not permitted once the free cancellation limit has been exceeded.">
                                    <i class="las la-exclamation-circle"></i>
                                </span>
                            </label>
                            <div class="input--group input-group">
                                <input class="form-control" name="user_cancellation_limit" type="number"
                                    value="{{ gs('user_cancellation_limit') }}" required min="0">
                                <span class="input-group-text">
                                    @lang('times')
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>
                                @lang('Maximum Negative Balance of Drivers')
                                <span data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                    title="If a driver reaches a negative balance, they can no longer join any trips.">
                                    <i class="las la-exclamation-circle"></i>
                                </span>
                            </label>
                            <div class="input--group input-group">
                                <input class="form-control" name="negative_balance_driver" type="number"
                                    value="{{ getAmount(gs('negative_balance_driver')) }}" required max="0">
                                <span class="input-group-text">
                                    {{ __(gs('cur_text')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>
                                @lang('Ride Automatically Cancel After')
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('If no bid is placed during this time, the ride will be automatically canceled.')">
                                    <i class="las la-info-circle"></i>
                                </span>
                            </label>
                            <div class="input-group">
                                <input class="form-control" name="ride_cancel_time" type="number"
                                    value="{{ gs('ride_cancel_time') }}">
                                <span class="input-group-text">@lang('MINUTE')</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>@lang('Preloader Image')</label>
                            <input class="form-control" name="preloader_image" type="file">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>@lang('Notification Audio')</label>
                            <input type="file" class="form-control" name="notification_audio">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Operating Country')</label>
                            <select name="operating_country[]" class="form-control select2 operating-country" multiple
                                required>
                                @foreach ($countries as $k => $country)
                                    <option value="{{ $k }}" @selected(@$operationCountry->$k)>
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Tips Suggest Amount')</label>
                            <select name="tips_suggest_amount[]" class="form-control select2-auto-tokenize select2-js-input" multiple
                                required>
                                @foreach ((gs('tips_suggest_amount') ?? []) as $k => $tipsAmount)
                                    <option value="{{ $tipsAmount }}" selected>
                                        {{gs('cur_sym').getAmount($tipsAmount) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="my-4">
                            <h5 class="divider-title">
                                @lang('MAP & PUSHER CONFIGURATION')
                            </h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('Google Maps Api')</label>
                            <input class="form-control" name="google_maps_api" type="text"
                                value="{{ gs('google_maps_api') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Pusher App ID') </label>
                            <input type="text" class="form-control" placeholder="@lang('App ID')"
                                name="pusher_app_id" value="{{ @$pusherConfig->app_id }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Pusher App Key') </label>
                            <input type="text" class="form-control" placeholder="@lang('App Key')"
                                name="pusher_app_key" value="{{ @$pusherConfig->app_key }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Pusher App Secret') </label>
                            <input type="text" class="form-control" placeholder="@lang('App Secret')"
                                name="pusher_app_secret" value="{{ @$pusherConfig->app_secret }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Pusher Cluster') </label>
                            <input type="text" class="form-control" placeholder="@lang('Cluster')"
                                name="pusher_cluster" value="{{ @$pusherConfig->cluster }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <x-admin.ui.btn.submit />
                    </div>
                </div>
            </x-admin.ui.card.body>
        </x-admin.ui.card>
    </form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel = "stylesheet" href = "{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    changeColor($(this), color.toHexString())
                }
            });
            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).closest('.form-group').find('.colorPicker').spectrum({
                    color: clr,
                    change: function(color) {
                        changeColor($(this), color.toHexString());
                    }
                });
                changeColor($(this), `#${clr}`)
            });

            $.each($('.colorCode'), function(i, element) {
                const $element = $(element);
                const colorCode = `#${$element.val()}`;
                changeColor($element, colorCode);
            });

            function changeColor($this, colorCode) {
                const $parent = $this.closest('.form-group');
                $parent.find('.input-group-text').css('border-color', colorCode);
                $parent.find('.sp-replacer').css('background', colorCode);
                $parent.find('.colorCode').val(colorCode.replace(/^#?/, ''));
            }

        })(jQuery);
    </script>
@endpush
@push('style')
    <style>
        [data-theme=dark] .sp-picker-container {
            border-left: solid 1px hsl(var(--light));
            background: hsl(var(--light));
        }

        [data-theme=dark] .sp-container {
            border-color: hsl(var(--border-color)) !important;
            border: solid 1px hsl(var(--border-color));
        }

        .divider-title {
            position: relative;
            text-align: center;
            width: max-content;
            margin: 0 auto;
        }

        .divider-title::before {
            position: absolute;
            content: '';
            top: 14px;
            left: -90px;
            background: #6b6b6b65;
            height: 2px;
            width: 80px;
        }

        .divider-title::after {
            position: absolute;
            content: '';
            top: 14px;
            right: -90px;
            background: #6b6b6b65;
            height: 2px;
            width: 80px;
        }

        label.required.no-required:after {
            display: none !important;
        }
    </style>
@endpush
