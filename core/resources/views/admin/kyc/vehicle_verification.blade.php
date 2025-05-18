@extends('admin.layouts.app')
@section('panel')
    <div class="submitRequired form-change-alert d-none">
        <i class="fas fa-exclamation-triangle"></i>
        @lang('You\'ve to click on the submit button to apply the changes')
    </div>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('admin.vehicle.verification.update') }}">
                @csrf
                <x-generated-form :form=$form generateTitle="Generate Form for Vehicle Verification"
                    formTitle="Form for Vehicle Verification"
                    formSubtitle="Securely verify vehicle identity through our simple form."
                    generateSubTitle="Quickly generate forms for easy driver vehicle verification." :randerbtn=true />
            </form>
        </div>
    </div>
@endsection
