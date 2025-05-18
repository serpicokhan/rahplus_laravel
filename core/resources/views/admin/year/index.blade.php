@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th> @lang('Model') </th>
                                    <th> @lang('Status') </th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($vehicleYears as $year)
                                    <tr>
                                        <td>{{ __($year->name) }}</td>
                                        <td>
                                            <x-admin.other.status_switch :status="$year->status" :action="route('admin.year.status', $year->id)"
                                                title="year" />
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.edit tag="button" :data-resource="$year" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($vehicleYears->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($vehicleYears) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-admin.ui.modal id="modal">
        <x-admin.ui.modal.header>
            <h4 class="modal-title"></h4>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.year.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>@lang('Name')</label>
                    <input class="form-control" name="name" type="number" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            const $modal = $("#modal");

            $(".edit-btn").on('click', function(e) {
                const data   = $(this).data('resource');
                const action = "{{ route('admin.year.store', ':id') }}";

                $("input[name='name']").val(data.name);
                $modal.find(".modal-title").text("@lang('Edit Year')");
                $modal.find('form').attr('action', action.replace(':id', data.id));
                $modal.modal("show");
            });

            $(".add-btn").on('click', function(e) {
                const action = "{{ route('admin.year.store') }}";
                $modal.find(".modal-title").text("@lang('Add Year')");
                $modal.find('form').trigger('reset');
                $modal.find('form').attr('action', action);
                $modal.modal("show");
            });
        })(jQuery);
    </script>
@endpush


@push('modal')
    <x-confirmation-modal />
@endpush

@push('breadcrumb-plugins')
    <x-admin.ui.btn.add tag="button" />
@endpush


@push('style')
    <style>
        .flex-thumb-wrapper .thumb img {
            border-radius: 5px;
        }
    </style>
@endpush
