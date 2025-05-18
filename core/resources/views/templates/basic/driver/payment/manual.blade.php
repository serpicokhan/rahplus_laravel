@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <div class="py-120 section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card  custom--card">
                        <div class="card-header card-header-bg">
                            <h5 class="card-title">{{ __($pageTitle) }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('driver.deposit.manual.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-primary">
                                            <p class="mb-0"><i class="las la-info-circle"></i> @lang('You are requesting')
                                                <b>{{ showAmount($data['amount']) }}</b> @lang('to deposit.') @lang('Please pay')
                                                <b>{{ showAmount($data['final_amount'], currencyFormat: false) . ' ' . $data['method_currency'] }}
                                                </b> @lang('for successful payment.')
                                            </p>
                                            <div class="mb-4">@php echo  $data->gateway->description @endphp</div>
                                        </div>
                                        <div class="mt-3">
                                            <x-ovo-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit"
                                                    class="btn btn--base w-100">@lang('Pay Now')</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
