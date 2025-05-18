@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout searchPlaceholder="Trx, username"
                        filterBoxLocation="reports.transaction_filter_form">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Rider')</th>
                                    <th class="text-start">@lang('Driver')</th>
                                    <th>@lang('Ride')</th>
                                    <th>@lang('Payment Type')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>
                                            <x-admin.other.user_info :user="$payment->rider" />
                                        </td>
                                        <td>
                                            <x-admin.other.driver_info :driver="$payment->driver" />
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.rides.detail', $payment->ride_id) }}">
                                                {{ @$payment->ride->uid }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($payment->payment_type == Status::PAYMENT_TYPE_CASH)
                                                <span class="badge badge--success">
                                                    @lang('Cash Payment')
                                                </span>
                                            @else
                                                <span class="badge badge--info">
                                                    @lang('Online Payment')
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ showAmount($payment->amount) }}
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="d-block ">{{ showDateTime($payment->created_at) }}</strong>
                                                <small class="d-block"> {{ diffForHumans($payment->created_at) }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($payments->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($payments) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection
