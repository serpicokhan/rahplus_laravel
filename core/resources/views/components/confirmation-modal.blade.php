@props(['isFrontend' => false])

<div id="confirmationModal" class="modal fade @if (!$isFrontend)  @endif" tabindex="-1" role="dialog"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog @if (!$isFrontend) modal-dialog-centered @endif" role="document">
        <div class="modal-content">
            <form method="POST">
                @csrf
                <div class="modal-body  @if (!$isFrontend) py-4 px-5 @endif">
                    <div class="text-center mb-4">
                        <h1 class=" text--warning mb-0"><i class="la la-warning"></i></h1>
                        <h4 class="mb-2">@lang('Please Confirm!')</h4>
                        <p class="question"></p>
                    </div>
                    <div class="d-flex gap-3 flex-wrap pt-2 pb-3">
                        <div class="flex-fill">
                            <button type="button"
                                class="btn w-100 @if (!$isFrontend) btn--secondary btn-large @else btn-dark @endif "
                                data-bs-dismiss="modal">
                                <i class="fa-regular fa-circle-xmark"></i> @lang('No')
                            </button>
                        </div>
                        <div class="flex-fill">
                            <button type="submit"
                                class="btn w-100  btn--primary  @if (!$isFrontend) btn-large @endif">
                                <i class="fa-regular fa-check-circle"></i> @lang('Yes')
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
