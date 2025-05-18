@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="maintenance-page flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center">
                    <img class="img-fluid mx-auto mb-3" src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}" alt="image">
                    <div>@php echo $maintenance->data_values->description @endphp</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
<style>
    header,nav,.footer{
        display:none !important;
    }
    footer{
        display:none;
    }
    .breadcrumb{
        display:none;
    }
    body{
        background-color:white;
        display: flex;
        align-items: center;
        height: 100vh;
        justify-content: center;
    }
    .maintenance-page  img{
        max-width: 500px;
    }
</style>
@endpush
