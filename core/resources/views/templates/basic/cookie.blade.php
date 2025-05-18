@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @php echo $cookie?->data_values?->description @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
