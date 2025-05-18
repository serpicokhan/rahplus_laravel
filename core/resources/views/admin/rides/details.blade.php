@extends('admin.layouts.app')
@section('panel')
    <div class="row responsive-row">
        <div class="col-lg-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Location & Distance Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Pickup Location')</span>
                            <span> {{ __(@$ride->pickup_location) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Destination')</span>
                            <span> {{ __(@$ride->destination) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Distance')</span>
                            <span class="badge badge--info"> {{ __(@$ride->distance) }} @lang('KM')</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Ride Start Time')</span>
                            @if (@$ride->start_time)
                                <span class="text--info">
                                    {{ showDateTime(@$ride->start_time) }}
                                </span>
                            @else
                                <span>
                                    @lang('Not available')
                                </span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Ride End Time')</span>
                            @if (@$ride->end_time)
                                <span class="text--info">
                                    {{ showDateTime(@$ride->end_time) }}
                                </span>
                            @else
                                <span>
                                    @lang('Not available')
                                </span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Duration')</span>
                            <span>
                                @lang('Approximately')
                                <span class="text--info"> {{ __(@$ride->duration) }}</span>
                            </span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
        <div class="col-lg-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Ride Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('UID')</span>
                            <span> {{ __($ride->uid) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Service')</span>
                            <span> {{ __($ride->service->name) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Ride Type')</span>
                            @if ($ride->ride_type == Status::INTER_CITY_RIDE)
                                <span class="badge badge--success"> @lang('Intercity Ride') </span>
                            @else
                                <span class="badge badge--info"> @lang('City Ride') </span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Amount')</span>
                            <span> {{ showAmount($ride->amount) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Note')</span>
                            <span>{{ __($ride->note ?? 'N/A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Status')</span>
                            <span> @php echo $ride->statusBadge @endphp </span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
        <div class="col-lg-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Rider Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Name')</span>
                            <span> {{ __(@$ride->user->fullname) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Email')</span>
                            <span> {{ __(@$ride->user->email) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Mobile')</span>
                            <span> {{ __(@$ride->user->mobileNumber) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Total Canceled Ride')</span>
                            <span class=" badge badge--danger">{{ $totalUserCancel }}</span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
        <div class="col-lg-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Driver Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Name')</span>
                            <span> {{ __(@$ride->driver->fullname ?? 'No driver available') }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Email')</span>
                            <span> {{ __(@$ride->driver->email ?? 'No driver available') }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Mobile')</span>
                            <span> {{ __(@$ride->driver->mobileNumber ?? 'No driver available') }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Total Canceled Ride')</span>
                            <span class="badge badge--danger">{{ $totalDriverCancel }}</span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
        <div class="col-lg-6">
            <x-admin.ui.card class="h-100">
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Bid Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Total Bids')</span>
                            <span> {{ $ride->bids->count() }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Max Bid')</span>
                            <span> {{ showAMount($ride->bids->max('bid_amount')) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Min Bid')</span>
                            <span> {{ showAMount($ride->bids->max('bid_amount')) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Offer Amount')</span>
                            <span class="text--info"> {{ showAMount($ride->amount) }} </span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
        <div class="col-lg-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Payment Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Payment Type')</span>
                            @if ($ride->payment_type == Status::PAYMENT_TYPE_CASH)
                                <span class="badge badge--success">
                                    @lang('Cash Payment')
                                </span>
                            @else
                                <span class="badge badge--info">
                                    @lang('Online Payment')
                                </span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Payment Status')</span>
                            <span> @php echo @$ride->paymentStatusType @endphp</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Amount')</span>
                            <span class="text--info">{{ showAmount(@$ride->amount) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Commission Amount')</span>
                            <span class=" text--warning">{{ showAmount(@$ride->commission_amount) }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                            <span>@lang('Driver Received')</span>
                            <span class=" text--success">{{ showAmount(@$ride->amount - $ride->commission_amount) }}
                            </span>
                        </li>
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>

            @if ($ride->userReview)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Rider Review & Rating')</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Rating')</span>
                                <span> {{ $ride->userReview->rating }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Review')</span>
                                <span> {{ __($ride->userReview->review) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            @if ($ride->driverReview)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Driver Review & Rating')</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Rating')</span>
                                <span> {{ $ride->driverReview->rating }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Review')</span>
                                <span> {{ __($ride->driverReview->review) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('SOS Alert')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    @if ($ride->sosAlert->count())
                        <ul class="list-group list-group-flush">
                            @foreach ($ride->sosAlert as $alert)
                                <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                    {{ __($alert->message) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 text-center">
                            <img src="{{ asset('assets/images/empty_box.png') }}" class="empty-message">
                            <span class="d-block">{{ __($emptyMessage) }}</span>
                            <span class="d-block fs-13 text-muted">@lang('There are no available data to display on this page at the moment.')</span>
                        </div>
                    @endif
                </x-admin.ui.card.body>
            </x-admin.ui.card>

            @if ($ride->userReview)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Rider Review & Rating')</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Rating')</span>
                                <span> {{ $ride->userReview->rating }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Review')</span>
                                <span> {{ __($ride->userReview->review) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            @if ($ride->driverReview)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Driver Review & Rating')</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Rating')</span>
                                <span> {{ $ride->driverReview->rating }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between ps-0 flex-wrap">
                                <span>@lang('Review')</span>
                                <span> {{ __($ride->driverReview->review) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
