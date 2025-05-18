@extends('admin.layouts.app')
@section('panel')
    @include('admin.rider.widget')
    <x-admin.ui.card class="table-has-filter">
        <x-admin.ui.card.body :paddingZero="true">
            <x-admin.ui.table.layout searchPlaceholder="Search rider" filterBoxLocation="rider.filter">
                <x-admin.ui.table>
                    <x-admin.ui.table.header>
                        <tr>
                            <th>@lang('User')</th>
                            <th>@lang('Email-Mobile')</th>
                            <th>@lang('Joined At')</th>
                            <th>@lang('Rides')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </x-admin.ui.table.header>
                    <x-admin.ui.table.body>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <x-admin.other.user_info :user="$user" />
                                </td>
                                <td>
                                    <div>
                                        <strong class="d-block">
                                            {{ $user->email }}
                                        </strong>
                                        <small>{{ $user->mobileNumber }}</small>
                                    </div>
                                </td>

                                <td>
                                    <div>
                                        <strong class="d-block ">{{ showDateTime($user->created_at) }}</strong>
                                        <small class="d-block"> {{ diffForHumans($user->created_at) }}</small>
                                    </div>
                                </td>
                                @php
                                    $totalRide = (clone $user->rides)->count();
                                    $completedRide = (clone $user->rides)
                                        ->where('status', Status::RIDE_COMPLETED)
                                        ->count();
                                    $canceledRide = (clone $user->rides)
                                        ->where('status', Status::RIDE_CANCELED)
                                        ->where('canceled_user_type', Status::USER)
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
                                <td>
                                    <x-admin.ui.btn.details :href="route('admin.rider.detail', $user->id)" />
                                </td>
                            </tr>
                        @empty
                            <x-admin.ui.table.empty_message />
                        @endforelse
                    </x-admin.ui.table.body>
                </x-admin.ui.table>
                @if ($users->hasPages())
                    <x-admin.ui.table.footer>
                        {{ paginateLinks($users) }}
                    </x-admin.ui.table.footer>
                @endif
            </x-admin.ui.table.layout>
        </x-admin.ui.card.body>
    </x-admin.ui.card>
@endsection
