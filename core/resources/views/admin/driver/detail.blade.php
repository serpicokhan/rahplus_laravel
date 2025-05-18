@extends('admin.layouts.app')
@section('panel')
    <div class="row responsive-row">
        <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="user-detail">
                        <div class="user-detail__user justify-content-center flex-column">
                            <div class="user-detail__thumb">
                                <img class="fit-image" src="{{ $driver->image_src }}">
                            </div>
                            <div class="user-detail__user-info">
                                <h5 class="user-detail__name mb-1">{{ __($driver->fullname) }}</h5>
                                <p class="user-detail__username">{{ '@' . $driver->username }}</p>
                            </div>
                        </div>
                        <div class="row gy-4 align-items-center">
                            <div class="col-md-6">
                                <ul class="user-detail__contact">
                                    <li class="item">
                                        <span>@lang('Email'): </span>
                                        <span>{{ $driver->email }}</span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Mobile number'): </span>
                                        <span>{{ $driver->mobileNumber }}</span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Country'): </span>
                                        <span>{{ __($driver->country_name) }}</span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Current Zone'): </span>
                                        <span>{{ __(@$driver->zone->name) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="user-detail__verification">
                                    <li class="item">
                                        <span>@lang('Email Verification')</span>
                                        <span>
                                            @if ($driver->ev)
                                                <i class="fas fa-check-circle text--success"></i>
                                            @else
                                                <i class="fas fa-times-circle text--danger"></i>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Mobile Verification')</span>
                                        <span>
                                            @if ($driver->sv)
                                                <i class="fas fa-check-circle text--success"></i>
                                            @else
                                                <i class="fas fa-times-circle text--danger"></i>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Document Verification')</span>
                                        <span>
                                            @if ($driver->dv == Status::VERIFIED)
                                                <i class="fas fa-check-circle text--success"></i>
                                            @else
                                                <i class="fas fa-times-circle text--danger"></i>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="item">
                                        <span>@lang('Vehicle Document Verification')</span>
                                        <span>
                                            @if ($driver->vv == Status::VERIFIED)
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
                                <div class="widget-card widget--primary">
                                    <a href="{{ route('admin.report.driver.transaction') }}?driver_id={{ $driver->id }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Balance')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($driver->balance, currencyFormat: false) }}
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
                                <div class="widget-card widget--success">
                                    <a href="{{ route('admin.report.rider.payment') }}?driver_id={{ $driver->id }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Total Payment Received')</p>
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
                                <div class="widget-card widget--success">
                                    <a href="{{ route('admin.deposit.list') }}?driver_id={{ $driver->id }}"
                                        class="widget-card-link"></a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fas fa-arrow-alt-circle-down"></i>
                                        </div>
                                        <div class="widget-content">
                                            <p class="widget-title">@lang('Total Deposit')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['total_deposit'], currencyFormat: false) }}
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
                                    <a
                                        href="{{ route('admin.withdraw.data.all') }}?driver_id={{ $driver->id }}"class="widget-card-link">
                                    </a>
                                    <div class="widget-card-left">
                                        <div class="widget-icon">
                                            <i class="fas fas fa-arrow-alt-circle-up"></i>
                                        </div>
                                        <div class="widget-card-content">
                                            <p class="widget-title">@lang('Total Withdrawal')</p>
                                            <h6 class="widget-amount">
                                                {{ gs('cur_sym') }}{{ showAmount($widget['total_withdraw'], currencyFormat: false) }}
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
            <x-admin.ui.widget.four url="{{ route('admin.rides.running') }}?driver_id={{ $driver->id }}"
                :currency="false" variant="primary" title="Running Ride" :value="$widget['running_ride']" icon="las la-spinner" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.completed') }}?driver_id={{ $driver->id }}"
                :currency="false" variant="success" title="Completed Ride" :value="$widget['completed_ride']" icon="las la-check-double" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.canceled') }}?driver_id={{ $driver->id }}"
                :currency="false" variant="danger" title="Canceled Ride" :value="$widget['canceled_ride']" icon="las la-times-circle" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="{{ route('admin.rides.all') }}?driver_id={{ $driver->id }}" :currency="false"
                variant="info" title="Total Ride" :value="$widget['total_ride']" icon="las la-list" />
        </div>
    </div>

    <div class="row responsive-row">
        <div class="col-xxl-8">
            <form action="{{ route('admin.driver.update', $driver->id) }}" method="POST" enctype="multipart/form-data"
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
                                            value="{{ $driver->firstname }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                        value="{{ $driver->lastname }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $driver->email }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group input--group ">
                                        <span class="input-group-text mobile-code">+{{ $driver->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $driver->mobile }}"
                                            id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Service')</label>
                                    <select name="service" class="form-control select2">
                                        <option value="">@lang('Select Service')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" @selected($service->id == $driver->service_id)>
                                                {{ __($service->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ @$driver->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$driver->city }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$driver->state }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ @$driver->zip }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}" @selected($driver->country_code == $key)>
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
                                        id="email_verification" name="ev" @checked($driver->ev)>
                                </div>
                            </div>
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="mobile_berification">
                                    @lang('Mobile Verification')
                                </label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="mobile_berification" name="sv" @checked($driver->sv)>
                                </div>
                            </div>
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="document_berification">
                                    @lang('Document Verification')
                                </label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="document_berification" name="dv" @checked($driver->dv == Status::VERIFIED )>
                                </div>
                            </div>
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="vehicle_berification">
                                    @lang('Vehicle Verification')
                                </label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="vehicle_berification" name="vv" @checked($driver->vv == Status::VERIFIED)>
                                </div>
                            </div>
                            <div class="verification-switch__item d-flex justify-content-between align-items-center gap-2">
                                <label class="form-check-label fw-500" for="2fa_verification">@lang('2FA Verification')</label>
                                <div class="form-check form-switch form-switch-success form--switch pl-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="2fa_verification"
                                        name="ts" @checked($driver->ts)>
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
                    <h5 class="card-title mb-0">@lang('Driver Document')</h5>
                    @php echo $driver->documentVerificationBadge; @endphp
                </div>
                <div class="card-body">
                    @if ($driver->driver_data)
                        <ul class="list-group list-group-flush">
                            @foreach ($driver->driver_data as $val)
                                @continue(!$val->value)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0 ps-0">
                                    <span>{{ __(keyToTitle($val->name)) }}</span>
                                    <span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            <a
                                                href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}">
                                                <i class="fa fa-file"></i> @lang('Attachment')
                                            </a>
                                        @else
                                            <p>{{ __($val->value) }}</p>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
                            <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                            <span class="d-block fs-14 text-muted">@lang('No document found')</span>
                        </div>
                    @endif

                    @if ($driver->driver_data && $driver->dv == Status::PENDING)
                        <div class=" d-flex gap-3 flex-lg-wrap mt-3">
                            <button class="btn btn--success confirmationBtn flex-fill" data-question="@lang('Are you sure to approve this document?')"
                                data-action="{{ route('admin.driver.verification.approve', $driver->id) }}">
                                <i class="las la-check me-1"></i>@lang('Approve')
                            </button>
                            <button class="btn btn--danger confirmationBtn flex-fill" data-question="@lang('Are you sure to reject this driver document?')"
                                data-action="{{ route('admin.driver.verification.reject', $driver->id) }}">
                                <i class="las la-ban me-1"></i>@lang('Reject')
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xxl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-3">
                    <h5 class="card-title mb-0">@lang('Vehicle Information')</h5>
                    @php echo $driver->vehicleVerificationBadge; @endphp
                </div>
                <div class="card-body">
                    @if (!blank(@$driver->vehicle->form_data))
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span>@lang('Service')</span>
                                <span> {{ __(@$driver->service->name) }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span>@lang('Brand')</span>
                                <span>{{ __(@$driver->vehicle->brand->name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span>@lang('Year')</span>
                                <span>{{ __(@$driver->vehicle->year->name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span>@lang('Model')</span>
                                <span>{{ __(@$driver->vehicle->model->name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span>@lang('Color')</span>
                                <span>{{ __(@$driver->vehicle->color->name) }}</span>
                            </li>
                            @foreach ($driver->vehicle->form_data as $val)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                    <span>{{ __(keyToTitle($val->name)) }}</span>
                                    <span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            <a
                                                href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}">
                                                <i class="fa fa-file"></i> @lang('Attachment')
                                            </a>
                                        @else
                                            <p>{{ __($val->value) }}</p>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
                            <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                            <span class="d-block fs-14 text-muted">@lang('No vehicle information driver is added')</span>
                        </div>
                    @endif
                    
                    @if (!blank(@$driver->vehicle->form_data) && $driver->vv == Status::PENDING)
                        <div class=" d-flex gap-2 flex-lg-wrap mt-3">
                            <button class="btn btn--success confirmationBtn" data-question="@lang('Are you sure to approve this document?')"
                                data-action="{{ route('admin.driver.vehicle.approve', $driver->id) }}">
                                <i class="las la-check me-1"></i>@lang('Approve')
                            </button>
                            <button class="btn btn--danger confirmationBtn" data-question="@lang('Are you sure to reject this driver document?')"
                                data-action="{{ route('admin.driver.vehicle.reject', $driver->id) }}">
                                <i class="las la-ban me-1"></i>@lang('Reject')
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center gap-3">
                    <h5 class="card-title mb-0">@lang('Rules')</h5>
                </div>
                <div class="card-body">
                    @if (!blank($driver->rules))
                        <ul class="list-group list-group-flush">
                            @foreach ($driver->rules as $rule)
                                <li class="list-group-item ps-0">
                                    <i class="text--success fa fa-check-circle me-1"></i> {{ __($rule) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
                            <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                            <span class="d-block fs-14 text-muted">@lang('No rule driver is added')</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-admin.ui.modal id="driverStatusModal">
        <x-admin.ui.modal.header>
            <div>
                <h4 class="modal-title">
                    @if ($driver->status == Status::USER_ACTIVE)
                        @lang('Ban Driver')
                    @else
                        @lang('Unban Driver')
                    @endif
                </h4>
                @if ($driver->status == Status::USER_ACTIVE)
                    <small>@lang('If this driver is banned, they will no longer have access to their dashboard.')</small>
                @else
                    <small>
                        <span class=" text--info">@lang('Ban reason was'):</span>
                        <span>{{ __($driver->ban_reason) }}</span>
                    </small>
                @endif
            </div>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.driver.status', $driver->id) }}" method="POST">
                @csrf
                @if ($driver->status == Status::USER_ACTIVE)
                    <div class="form-group">
                        <label>@lang('Reason')</label>
                        <textarea class="form-control" name="reason" rows="4" required></textarea>
                    </div>
                @else
                    <h4 class="mt-3 text-center text--warning">@lang('Are you sure to unban this driver?')</h4>
                @endif
                <div class="form-group">
                    @if ($driver->status == Status::USER_ACTIVE)
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

    <x-admin.ui.modal id="addSubModal">
        <x-admin.ui.modal.header>
            <div>
                <h4 class="modal-title">@lang('Add Balance')</h4>
                <small class="modal-subtitle">@lang('Add funds to rider accounts by entering the desired amount  below')</small>
            </div>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form method="POST" action="{{ route('admin.driver.add.sub.balance', $driver->id) }}">
                @csrf
                <input type="hidden" name="act">
                <div class="form-group">
                    <label class="form-label">@lang('Amount')</label>
                    <div class="input-group input--group">
                        <input type="number" step="any" min="0" name="amount" class="form-control"
                            placeholder="@lang('Enter amount')" required>
                        <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Remark')</label>
                    <textarea class="form-control" placeholder="@lang('Enter remark')" name="remark" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class=" d-flex gap-2  flex-wrap">
        <button type="button" class=" flex-fill btn  btn--success balance-adjust" data-act="add">
            <i class="las la-plus me-1"></i>@lang('Balance')
        </button>
        <button type="button" class="flex-fill btn  btn--danger balance-adjust" data-act="sub">
            <i class="las la-minus-circle me-1"></i>@lang('Balance')
        </button>

        @if ($driver->status == Status::USER_ACTIVE)
            <button type="button" class="flex-fill btn  btn--warning" data-bs-toggle="modal"
                data-bs-target="#driverStatusModal">
                <i class="las la-ban me-1"></i>@lang('Ban Driver')
            </button>
        @else
            <button type="button" class="flex-fill btn  btn--info" data-bs-toggle="modal"
                data-bs-target="#driverStatusModal">
                <i class="las la-ban me-1"></i>@lang('Unban Driver')
            </button>
        @endif
        <a href="{{ route('admin.report.driver.notification.history') }}?driver_id={{ $driver->id }}"
            class="flex-fill btn  btn--secondary">
            <i class="las la-bell me-1"></i>@lang('Notifications')
        </a>
    </div>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {

            $(".balance-adjust").on('click', function(e) {
                const modal = $('#addSubModal');
                const act = $(this).data('act');
                const id = $(this).data('id');

                if (act == 'add') {
                    modal.find(".modal-title").text("@lang('Add Balance')");
                    modal.find(".modal-subtitle").text("@lang('Add funds to driver accounts by entering the desired amount below')");
                } else {
                    modal.find(".modal-title").text("@lang('Subtract Balance')");
                    modal.find(".modal-subtitle").text("@lang('Subtract funds to driver accounts by entering the desired amount below')");
                }
                modal.find('input[name=act]').val(act);
                modal.modal('show');
            });

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
            grid-template-columns: repeat(5, 1fr);
        }

        .verification-switch__item:first-child:after {
            display: none !important;
        }

        @media (max-width: 1599px) {
            .verification-switch {
                grid-template-columns: repeat(3, 1fr);
            }

            .verification-switch__item:nth-child(4):after {
                display: none !important;
            }

        }

        @media (max-width: 767px) {
            .verification-switch {
                grid-template-columns: repeat(2, 1fr);
            }

            .verification-switch__item::after {
                display: none !important;
            }
        }

        @media (max-width: 400px) {
            .verification-switch {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        .verification-switch__item .form-check-label {
            font-size: 0.875rem;
        }

        .select2-container {
            width: 100% !important;
        }

        .verification-switch__item::before {
            display: none !important;
        }

        .verification-switch__item::after {
            position: absolute;
            left: -15px;
            content: '';
            width: 1.5px;
            height: 100%;
            background-color: hsl(var(--border-color));
        }
    </style>
@endpush
