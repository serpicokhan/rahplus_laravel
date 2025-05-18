@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $blogContent = getContent('blog.content', true);
    @endphp
    <section class="blog-section blog-page pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('Template::partials.breadcumb')
                </div>
            </div>
            <div class="row gy-5 justify-content-center">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-sm-6">
                        <div class="blog-item-two">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="blog-item-two__thumb d-block">
                                <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '415x195') }}"
                                    alt="image">
                            </a>
                            <div class="blog-item-two__content">
                                <span class="blog-item-two__date">{{ showDateTime(@$blog->created_at, 'd F Y') }}</span>
                                <h5 class="blog-item-two__title">
                                    <a href="{{ route('blog.details', $blog->slug) }}"
                                        class="blog-item-two__title-link border-effect">
                                        {{ __(strLimit(@$blog->data_values->title, 80)) }}
                                    </a>
                                </h5>
                                <p class="blog-item-two__desc">
                                    {{ __(strLimit(strip_tags(@$blog->data_values->description), 100)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($blogs->hasPages())
                    <div class="col-12">
                        {{ paginateLinks($blogs) }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

@push('style')
    <style>
        .blog-page {
            padding-top: 140px;
        }

        .blog-item-two {
            background: hsl(var(--white));
            box-shadow: var(--box-shadow);
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
        }

        .blog-item-two__thumb img {
            width: 100%;
        }

        .blog-item-two__content {
            padding: 15px 15px 25px;
        }

        .blog-item-two__date {
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1;
            background: hsl(var(--success)/.15);
            color: hsl(var(--success));
            border-radius: 32px;
            padding: 9px 15px;
            margin-bottom: 15px;
        }

        .blog-item-two__title {
            margin-bottom: 12px;
        }

        @media (max-width: 1399px) {
            .blog-page {
                padding-top: 135px;
            }
        }

        @media (max-width: 1199px) {
            .blog-page {
                padding-top: 120px;
            }

            .blog-item-two__date {
                padding: 8px 15px;
                margin-bottom: 12px;
            }

            .blog-item-two__title {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 991px) {
            .blog-page {
                padding-top: 95px;
            }
        }

        @media (max-width: 767px) {
            .blog-page {
                padding-top: 85px;
            }

            .blog-item-two__date {
                font-size: 0.813rem;
            }

            .blog-item-two__content {
                padding: 12px 12px 20px;
            }
        }

        @media (max-width: 575px) {
            .blog-page {
                padding-top: 85px;
            }

            .blog-item-two__content {
                padding: 12px 15px 25px;
            }
        }
    </style>
@endpush
