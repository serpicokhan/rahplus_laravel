@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <div class="preloader">
        <img src="{{ getImage(getFilePath('preloader') . '/' . gs('preloader_image')) }}" alt="image">
    </div>
    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>

    @stack('fbComment')

    @include('Template::partials.header')

    @yield('content')
    @include('Template::partials.footer')
@endsection
