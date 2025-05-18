@extends('admin.layouts.app')
@section('panel')
    @include('admin.driver.widget')
    <x-admin.ui.card class="table-has-filter">
        <x-admin.ui.card.body :paddingZero="true">
            <x-admin.ui.table.layout searchPlaceholder="Search driver" filterBoxLocation="driver.filter">
                <x-admin.ui.table>
                    <x-admin.ui.table.header>
                        <tr>
                            <th>@lang('Driver')</th>
                            <th>@lang('Email-Mobile')</th>
                            <th>@lang('Rides')</th>
                            <th>@lang('Balance')</th>
                            <th>@lang('Joined At')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </x-admin.ui.table.header>
                    <x-admin.ui.table.body>
                        @forelse($drivers as $driver)
                            <tr>
                                <td>
                                    <x-admin.other.driver_info :driver="$driver" />
                                </td>
                                <td>
                                    <div>
                                        <strong class="d-block">
                                            {{ $driver->email }}
                                        </strong>
                                        <small>{{ $driver->mobileNumber }}</small>
                                    </div>
                                </td>

                                @php
                                    $totalRide = (clone $driver->ride)->count();
                                    $completedRide = (clone $driver->ride)
                                        ->where('status', Status::RIDE_COMPLETED)
                                        ->count();
                                    $canceledRide = (clone $driver->ride)
                                        ->where('status', Status::RIDE_CANCELED)
                                        ->where('canceled_user_type', Status::DRIVER)
                                        ->count();
                                @endphp
                                <td>
                                    <div>
                                        <span>
                                            @lang('total')
                                            <span class=" text--info">
                                                {{ $totalRide }}
                                            </span>
                                            |
                                        </span>
                                        <span>
                                            @lang('completed')
                                            <span class="text--success">
                                                {{ $completedRide }}
                                            </span>
                                            |
                                        </span>
                                        <span>
                                            @lang('canceled')
                                            <span class="text--danger">
                                                {{ $canceledRide }}
                                            </span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ showAmount($driver->balance) }}</td>
                                <td>
                                    <div>
                                        <strong class="d-block ">{{ showDateTime($driver->created_at) }}</strong>
                                        <small class="d-block"> {{ diffForHumans($driver->created_at) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <x-admin.ui.btn.details :href="route('admin.driver.detail', $driver->id)" />
                                </td>
                            </tr>
                        @empty
                            <x-admin.ui.table.empty_message />
                        @endforelse
                    </x-admin.ui.table.body>
                </x-admin.ui.table>
                @if ($drivers->hasPages())
                    <x-admin.ui.table.footer>
                        {{ paginateLinks($drivers) }}
                    </x-admin.ui.table.footer>
                @endif
            </x-admin.ui.table.layout>
        </x-admin.ui.card.body>
    </x-admin.ui.card>
@endsection
