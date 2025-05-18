@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="breadcrumb mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('Template::partials.breadcumb', ['insSectionClass' => ''])
                </div>
            </div>
        </div>
    </div>
    <div class="py-60">
        <div class="blog-detials">
            <div class="container">
                <div class="row gy-4 justify-content-center ">
                    <div class="col-xl-9 col-lg-8">
                        <div class="blog-details">
                            <div class="blog-details__thumb">
                                <img src="{{ frontendImage('blog', @$blog->data_values->image, '965x450') }}" class="w-100"
                                    alt="Blog Image">
                            </div>
                            <div class="blog-details__content">
                                <span class="blog-item__time mb-2">
                                    <span class="blog-item__date-icon"><i class="las la-clock"></i></span>
                                    {{ showDateTime(@$blog->created_at, 'd M, Y') }}
                                </span>
                                <h3 class="blog-details__title">
                                    {{ __($blog->data_values->title) }}
                                </h3>
                                <div class="blog-details__desc">
                                    @php echo $blog->data_values->description @endphp
                                </div>
                                <div class="blog-details__share d-flex align-items-center mt-4 flex-wrap">
                                    <ul class="social-list">
                                        <li class="social-list__item">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}%2Fblog%2F{{ __(@$blog->data_values->title) }}"
                                                target="_blank" class="social-list__link flex-center facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://twitter.com/intent/tweet?text={{ __(@$blog->data_values->title) }}&amp;url={{ url()->current() }}"
                                                target="_blank" class="social-list__link flex-center twitter">
                                                <i class="fab fa-x-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://pinterest.com/pin/create/bookmarklet/?media={{ frontendImage('blog', @$blog->data_values->image, '965x450') }}g&url={{ url()->current() }}%2Fblog%2F{{ __(@$blog->data_values->title) }}"
                                                target="_blank" class="social-list__link flex-center pinterest">
                                                <i class="fab fa-pinterest-p"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url()->current() }}%2Fblog%2F{{ __(@$blog->data_values->title) }}"
                                                target="_blank" class="social-list__link flex-center linkedin">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="blog-sidebar-wrapper">
                            <div class="blog-sidebar">
                                <h5 class="blog-sidebar__title">@lang('Latest Blog') </h5>
                                @foreach ($latestBlogs as $latestBlog)
                                    <div class="latest-blog">
                                        <div class="latest-blog__thumb">
                                            <a href="{{ route('blog.details', $latestBlog->slug) }}">
                                                <img src="{{ frontendImage('blog', @$latestBlog->data_values->image) }}"
                                                    alt="Blog Image" class="fit-image">
                                            </a>
                                        </div>
                                        <div class="latest-blog__content">
                                            <h6 class="latest-blog__title">
                                                <a href="{{ route('blog.details', $latestBlog->slug) }}">
                                                    {{ __(@$latestBlog->data_values->title) }}
                                                </a>
                                            </h6>
                                            <span class="latest-blog__date">
                                                {{ showDateTime(@$blog->created_at, 'd M, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
