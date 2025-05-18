@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body :paddingZero=true>
                    <x-admin.ui.table.layout searchPlaceholder="Search" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Review By')</th>
                                    <th>@lang('Ride')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>
                                            @if ($review->user_id)
                                                <div
                                                    class="d-flex align-items-end align-items-lg-center gap-2 flex-wrap  flex-column flex-lg-row">
                                                    <div>
                                                        <span
                                                            class="d-block fs-14">{{ @__($review->ride->driver->fullname) }}</span>
                                                        <small class="fs-12">@lang('driver')</small>
                                                    </div>
                                                    <span>
                                                        <i
                                                            class="fa fa-arrow-alt-circle-down text--info d-block d-lg-none"></i>
                                                        <i
                                                            class="fa fa-arrow-alt-circle-right text--info d-none d-lg-block"></i>
                                                    </span>
                                                    <div>
                                                        <span
                                                            class="d-block fs-14">{{ __(@$review->ride->user->fullname) }}</span>
                                                        <small class="fs-12">@lang('rider')</small>
                                                    </div>
                                                </div>
                                            @else
                                                <div
                                                    class="d-flex align-items-end align-items-lg-center gap-2 flex-wrap  flex-column flex-lg-row">
                                                    <div>
                                                        <span
                                                            class="d-block fs-14">{{ __(@$review->ride->user->fullname) }}</span>
                                                        <small class="fs-12">@lang('rider')</small>
                                                    </div>
                                                    <span>
                                                        <i
                                                            class="fa fa-arrow-alt-circle-down text--info d-block d-lg-none"></i>
                                                        <i
                                                            class="fa fa-arrow-alt-circle-right text--info d-none d-lg-block"></i>
                                                    </span>
                                                    <div>
                                                        <span
                                                            class="d-block fs-14">{{ @__($review->ride->driver->fullname) }}</span>
                                                        <small class="fs-12">@lang('driver')</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.rides.detail', $review->ride_id) }}">
                                                {{ $review->ride->uid }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="rating badge badge--warning">{{ $review->rating }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class=" d-block">
                                                    {{ showDateTime($review->created_at) }}
                                                </span>
                                                <span class="fs-12 text--info">
                                                    {{ diffForHumans($review->created_at) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.details text="Show Review" tag="btn" :data-review="$review" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($reviews->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($reviews) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-admin.ui.modal id="modal">
        <x-admin.ui.modal.header>
            <h4 class="modal-title">@lang('View Review')</h4>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <ul class=" list-group list-group-flush">
                <li class=" list-group-item d-flex flex-wrap justify-content-between gap-1 ps-0">
                    <span>@lang('Rating')</span>
                    <span class="rating badge badge--info"></span>
                </li>
                <li class=" list-group-item d-flex flex-wrap justify-content-between gap-1 ps-0">
                    <span>@lang('Review')</span>
                    <span class="review"></span>
                </li>
            </ul>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.details-btn').on('click', function() {
                var $modal = $('#modal');
                var review = $(this).data('review');
                $modal.find('.rating').text(review.rating)
                $modal.find('.review').text(review.review)
                $modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
