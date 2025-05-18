@extends('admin.layouts.app')
@section('panel')
    <div class="row responsive-row">
        <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="user-detail">
                        <div class="user-detail__user justify-content-center flex-column">
                            <div class="user-detail__thumb">
                                <img class="fit-image" src="{{ $user->image_src }}" alt="user">
                            </div>
                            <div class="user-detail__user-info">
                                <h5 class="user-detail__name mb-1">{{ __($user->fullname) }}</h5>
                                <p class="user-detail__username">{{ '@' . $user->username }}</p>
                            </div>
                        </div>
                        <div class="row gy-4 align-items-center">
                            <div class="col-md-6">
                                <ul class="user-detail__contact">
                                    <li class="item">
                                        <span>@lang('Email'): </span>
                                        <span>{{ $user->email }}</span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Mobile number'): </span>
                                        <span>{{ $user->mobileNumber }}</span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Country'): </span>
                                        <span>{{ __($user->country_name) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="user-detail__verification">
                                    <li class="item">
                                        <span>@lang('Email Verification')</span>
                                        <span>
                                            @if ($user->ev)
                                                <i class="fas fa-check-circle text--success"></i>
                                            @else
                                                <i class="fas fa-times-circle text--danger"></i>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Mobile Verification')</span>
                                        <span>
                                            @if ($user->sv)
                                                <i class="fas fa-check-circle text--success"></i>
                                            @else
                                                <i class="fas fa-times-circle text--danger"></i>
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card shadow-none h-100 ">
                <div class="card-header border-0">
                    <h5 class="card-title">@lang('Financial Overview')</h5>
                </div>
                <div class="card-body">
                    <div class="widget-card-wrapper custom-widget-wrapper">
                        <div class="row g-0">
                            <div class="col-sm-6">
                                <div class="widget-card widget--success">
                                    <a href="{{ route('admin.report.rider.payment') }}?user_id={{ $user->id }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Total Payment')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['total_payment'], currencyFormat: false) }}
                                                <span class="currency">
                                                    {{ __(gs('cur_text')) }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                    <span class="widget-card-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-card widget--warning">
                                    <a href="{{ route('admin.report.rider.payment') }}?user_id={{ $user->id }}&payment_type={{ Status::PAYMENT_TYPE_CASH }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fa-solid fa-sack-dollar"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Total Cash Payment')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['total_payment_cash'], currencyFormat: false) }}
                                                <span class="currency">
                                                    {{ __(gs('cur_text')) }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                    <span class="widget-card-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-card widget--info">
                                    <a href="{{ route('admin.report.rider.payment') }}?user_id={{ $user->id }}&payment_type={{ Status::PAYMENT_TYPE_GATEWAY }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fa-brands fa-cc-paypal"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Total Online Payment')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['total_payment_gateway'], currencyFormat: false) }}
                                                <span class="currency">
                                                    {{ __(gs('cur_text')) }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                    <span class="widget-card-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-card widget--primary">
                                    <a href="{{ route('admin.report.rider.payment') }}?user_id={{ $user->id }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Last Payment Amount')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['last_payment_amount'], currencyFormat: false) }}
                                                <span class="currency">
                                                    {{ __(gs('cur_text')) }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                    <span class="widget-card-arrow">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row responsive-row">
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.running') }}?user_id={{ $user->id }}"
                :currency="false" variant="primary" title="Running Ride" :value="$widget['running_ride']" icon="las la-spinner" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.completed') }}?user_id={{ $user->id }}"
                :currency="false" variant="success" title="Completed Ride" :value="$widget['completed_ride']" icon="las la-check-double" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.canceled') }}?user_id={{ $user->id }}"
                :currency="false" variant="danger" title="Canceled Ride" :value="$widget['canceled_ride']" icon="las la-times-circle" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.all') }}?user_id={{ $user->id }}" :currency="false"
                variant="info" title="Total Ride" :value="$widget['total_ride']" icon="las la-list" />
        </div>
    </div>
    <div class="row responsive-row">
        <div class="col-xxl-8">
            <form action="{{ route('admin.rider.update', [$user->id]) }}" method="POST" enctype="multipart/form-data"
                class="user-form">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-3">
                        <h5 class="card-title mb-0">@lang('Full Information')</h5>
                        <div class=" d-none d-md-block">
                            <button type="submit" class="btn btn--primary fw-500 disabled" disabled>
                                <i class="fa-regular fa-paper-plane me-1"></i><span>@lang('Update')</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>@lang('First Name')</label>
                                        <input class="form-control" type="text" name="firstname" required
                                            value="{{ $user->firstname }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group input--group ">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $user->mobile }}" id="mobile"
                                            class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Address')</label>
                                <input class="form-control" type="text" name="address"
                                    value="{{ @$user->address }}">
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$user->city }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$user->state }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ @$user->zip }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}" @selected($user->country_code == $key)>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="verification-switch">
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="email_verification">@lang('Email Verification')</label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="email_verification" name="ev" @checked($user->ev)>
                                </div>
                            </div>
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="mobile_berification">
                                    @lang('Mobile Verification')
                                </label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="mobile_berification" name="sv" @checked($user->sv)>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-md-none mt-3">
                            <x-admin.ui.btn.submit disabled="disabled" class="disabled" text="Update" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center gap-3">
                    <h5 class="card-title mb-0">@lang('Login History')</h5>
                    <a href="{{ route('admin.report.rider.login.history') }}?user_id={{ $user->id }}"
                        class="btn btn--primary fw-500 @if (!$loginLogs->count()) disabled @endif">
                        <span>@lang('View All')</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="login-history h-100">
                        @forelse ($loginLogs as $loginLog)
                            <div class="login-history__item d-flex justify-content-between align-items-center">
                                <div class="login-history__item-content d-flex align-items-center gap-2">
                                    <div class="login-history__item__icon">
                                        @if (in_array(strtolower($loginLog->os), os()))
                                            <i class="fab fa-{{ strtolower($loginLog->os) }}"></i>
                                        @else
                                            <i class="fa fa-desktop"></i>
                                        @endif
                                    </div>
                                    <div class="login-history__info">
                                        <p class="login-history__item-title">{{ __($loginLog->os) }}</p>
                                        <p class="login-history__item-desc text--secondary">
                                            {{ __($loginLog->browser) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="login-history__item-time">
                                    <p>{{ __($loginLog->user_ip) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
                                <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                                <span class="d-block fs-14 text-muted">{{ __($emptyMessage) }}</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-admin.ui.modal id="userStatusModal">
        <x-admin.ui.modal.header>
            <div>
                <h4 class="modal-title">
                    @if ($user->status == Status::USER_ACTIVE)
                        @lang('Ban Rider')
                    @else
                        @lang('Unban Rider')
                    @endif
                </h4>
                @if ($user->status == Status::USER_ACTIVE)
                    <small>@lang('If this rider is banned, they will no longer have access to their dashboard.')</small>
                @else
                    <small>
                        <span class=" text--info">@lang('Ban reason was'):</span>
                        <span>{{ __($user->ban_reason) }}</span>
                    </small>
                @endif
            </div>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.rider.status', $user->id) }}" method="POST">
                @csrf
                @if ($user->status == Status::USER_ACTIVE)
                    <div class="form-group">
                        <label>@lang('Reason')</label>
                        <textarea class="form-control" name="reason" rows="4" required></textarea>
                    </div>
                @else
                    <h4 class="mt-3 text-center text--warning">@lang('Are you sure to unban this rider?')</h4>
                @endif
                <div class="form-group">
                    @if ($user->status == Status::USER_ACTIVE)
                        <x-admin.ui.btn.modal />
                    @else
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="button" class="btn btn--secondary btn-large" data-bs-dismiss="modal">
                                <i class="las la-times"></i> @lang('No')
                            </button>
                            <button type="submit" class="btn btn--primary btn-large">
                                <i class=" las la-check-circle"></i> @lang('Yes')
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>
@endsection

@push('breadcrumb-plugins')
    <div class=" d-flex gap-2  flex-wrap">
        @if ($user->status == Status::USER_ACTIVE)
            <button type="button" class="flex-fill btn  btn--warning" data-bs-toggle="modal"
                data-bs-target="#userStatusModal">
                <i class="las la-ban me-1"></i>@lang('Ban Rider')
            </button>
        @else
            <button type="button" class="flex-fill btn  btn--info" data-bs-toggle="modal"
                data-bs-target="#userStatusModal">
                <i class="las la-ban me-1"></i>@lang('Unban Rider')
            </button>
        @endif
        <a href="{{ route('admin.report.rider.notification.history') }}?user_id={{ $user->id }}"
            class="flex-fill btn  btn--secondary">
            <i class="las la-bell me-1"></i>@lang('Notifications Logs')
        </a>
    </div>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {


            const inputValues = {};
            const $formElements = $('.user-form input, .user-form select').not("[name=_token]");
            const $submitButton = $(".user-form").find('button[type=submit]');

            $formElements.each(function(i, element) {
                const $element = $(element);
                const name = $element.attr('name');
                const type = $element.attr('type');
                var value = $element.val();

                if (type == 'checkbox') {
                    value = $element.is(":checked");
                }
                const inputValue = {
                    inittial_value: value,
                    new_value: value,
                }
                inputValues[name] = inputValue;
            });

            $(".user-form").on('input change', 'input,select', function(e) {
                const name = $(this).attr('name');
                const type = $(this).attr('type');
                var value = $(this).val();

                if (type == 'checkbox') {
                    value = $(this).is(":checked");
                }

                const oldInputValue = inputValues[name];
                const newInputValue = {
                    inittial_value: oldInputValue.inittial_value,
                    new_value: value,
                };
                inputValues[name] = newInputValue;

                btnEnableDisable();
            });

            // submit btn disable/enable depend on input values
            function btnEnableDisable() {
                var isDisabled = true;
                $.each(inputValues, function(i, element) {
                    if (element.inittial_value != element.new_value) {
                        isDisabled = false;
                        return;
                    }
                });
                if (isDisabled) {
                    $submitButton.addClass("disabled").attr('disabled', true);
                } else {
                    $submitButton.removeClass("disabled").attr('disabled', false);
                }
            }

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });
        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .verification-switch {
            grid-template-columns: repeat(2, 1fr);
        }
    </style>
@endpush
