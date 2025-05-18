@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout filterBoxLocation="rides.filter_form">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Rider')</th>
                                    <th class="text-start">@lang('Driver')</th>
                                    <th>@lang('Service') | @lang('Ride Type')</th>
                                    <th>@lang('Pickup Location')</th>
                                    <th>@lang('Destination')</th>
                                    <th>@lang('Ride Fare') | @lang('Total Bids')</th>
                                    @if (request()->routeIS('admin.rides.all'))
                                        <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($rides as $ride)
                                    <tr>

                                        <td> <x-admin.other.user_info :user="$ride->user" /></td>
                                        <td>
                                            @if ($ride->driver)
                                                <x-admin.other.driver_info :driver="$ride->driver" />
                                            @else
                                                <span class="text-start w-100">@lang('No driver available')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="d-block">
                                                    {{ __(@$ride->service->name) }}
                                                </span>
                                                @if ($ride->ride_type == Status::CITY_RIDE)
                                                    <span>@lang('City Ride')</span>
                                                @else
                                                    <span>@lang('InterCity Ride')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ __($ride->pickup_location) }} </td>
                                        <td>{{ __($ride->destination) }} </td>
                                        <td>
                                            <div>
                                                <span class="d-block">
                                                    {{ showAmount($ride->amount) }}
                                                </span>
                                                <span class="mt-2">
                                                    <a class="badge badge--primary"
                                                        href="{{ route('admin.rides.bids', $ride->id) }}">
                                                        {{ $ride->bids_count }}
                                                    </a>
                                                </span>
                                            </div>

                                        </td>
                                        @if (request()->routeIS('admin.rides.all'))
                                            <td>
                                                @php echo $ride->statusBadge @endphp
                                            </td>
                                        @endif
                                        <td>
                                            <x-admin.ui.btn.details :href="route('admin.rides.detail', $ride->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($rides->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($rides) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection
