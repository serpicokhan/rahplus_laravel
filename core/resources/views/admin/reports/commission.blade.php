@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout searchPlaceholder="Trx, username" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Driver')</th>
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Transacted')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($commissions as $commission)
                                    <tr>
                                        <td>
                                            <x-admin.other.driver_info :driver="$commission->driver" />
                                        </td>
                                        <td>
                                            <strong>{{ $commission->trx }}</strong>
                                        </td>
                                        <td>
                                            {{ showDateTime($commission->created_at) }}<br>{{ diffForHumans($commission->created_at) }}
                                        </td>
                                        <td>
                                            <span>
                                                {{ showAmount($commission->amount) }}
                                            </span>
                                        </td>
                                        <td>{{ __($commission->details) }}</td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($commissions->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($commissions) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection
