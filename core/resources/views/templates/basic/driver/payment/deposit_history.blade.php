@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <div class="pt-120 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="redirect-to-app">
                        <div class="spinner-border text--base mb-4" role="status">
                        </div>
                        <h4 class="mb-1  fw-bold">@lang('REDIRECTING TO THE APP')</h4>
                        <p class="text-dark">@lang('Thank you for your patience. Please hold on as we are redirecting you to the app shortly. ')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .redirect-to-app {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            background: hsl(var(--base)/0.5);
            border-radius: 7px;
            flex-direction: column
        }

        .spinner-border {
            --bs-spinner-width: 4rem;
            --bs-spinner-height: 4rem;
            --bs-spinner-border-width: 0.5em;
        }
    </style>
@endpush
