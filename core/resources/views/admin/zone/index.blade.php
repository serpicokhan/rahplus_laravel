@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout searchPlaceholder="Search zone" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($zones as $zone)
                                    <tr>
                                        <td> {{ __($zone->name) }}</td>
                                        <td>
                                            <x-admin.other.status_switch :status="$zone->status" :action="route('admin.zone.status', $zone->id)"
                                                title="zone" />
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.edit :href="route('admin.zone.edit', $zone->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($zones->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($zones) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-admin.ui.btn.add :href="route('admin.zone.create')" />
@endpush
