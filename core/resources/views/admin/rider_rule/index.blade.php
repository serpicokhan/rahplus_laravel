@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout searchPlaceholder="Search rule" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th> @lang('Name') </th>
                                    <th> @lang('Status') </th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($rules as $rule)
                                    <tr>
                                        <td>{{ __($rule->name) }}</td>
                                        <td>
                                            <x-admin.other.status_switch :status="$rule->status" :action="route('admin.rider.rule.status', $rule->id)"
                                                title="rule" />
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.edit tag="btn" data-resource="{{ $rule }}" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($rules->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($rules) }}
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
            <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>@lang('Rule Name')</label>
                    <input class="form-control" name="name" type="text" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>
@endsection

@push('breadcrumb-plugins')
    <x-admin.ui.btn.add tag="btn" />
@endpush

@push('modal')
    <x-confirmation-modal />
@endpush


@push('script')
    <script>
        "use strict";
        (function($) {

            const $modal = $("#modal");

            $(".add-btn").on('click', function(e) {
                const action = "{{ route('admin.rider.rule.store') }}";
                $modal.find(".modal-title").text("@lang('Add Rule')");
                $modal.find('form').trigger('reset');
                $modal.find('form').attr('action', action);
                $modal.modal("show");
            });

            $(".edit-btn").on('click', function(e) {
                const data = $(this).data('resource');
                const action = "{{ route('admin.rider.rule.store', ':id') }}";
                $("input[name='name']").val(data.name);
                $modal.find(".modal-title").text("@lang('Edit Rule')");
                $modal.find('form').attr('action', action.replace(':id', data.id));
                $modal.modal("show");
            });

        })(jQuery);
    </script>
@endpush
