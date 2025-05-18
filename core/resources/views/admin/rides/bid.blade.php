@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout :renderTableFilter="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Driver')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($bids as $bid)
                                    <tr>
                                        <td>
                                            <x-admin.other.driver_info :driver="@$bid->driver" />
                                        </td>
                                        <td>
                                            {{ showAmount(@$bid->bid_amount) }}
                                        </td>
                                        <td>
                                            <div>
                                                {{ showDateTime($bid->created_at) }} <br>
                                                {{ diffForHumans($bid->created_at) }}
                                            </div>
                                        </td>
                                        <td>
                                            @php echo $bid->statusBadge @endphp
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse

                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($bids->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($bids) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection
