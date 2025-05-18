@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body>
                    <form action="{{ route('admin.promotional.notification.all.send') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-8 col-lg-12">
                                <div class="form-group">
                                    <label>@lang('User Type') </label>
                                    <select class="form-control select2" name="user_type" required
                                        data-minimum-results-for-search="-1">
                                        <option value="all">@lang('All')</option>
                                        <option value="rider">@lang('Rider')</option>
                                        <option value="driver">@lang('Driver')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Title')</label>
                                    <input class="form-control" name="title" type="text"
                                        placeholder="@lang('Title')" required />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Message') </label>
                                    <textarea class="form-control" name="message" required></textarea>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader class="w-100" name="image" type="promotional_notify"
                                        :required="false" />
                                </div>
                            </div>
                        </div>
                        <x-admin.ui.btn.submit />
                    </form>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <span class="text--info fw-semibold">
        <i>
            @lang('Notifications will be sent using push notifications')
        </i>
    </span>
@endpush
