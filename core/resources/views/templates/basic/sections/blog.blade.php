@php
    $blogContent  = getContent('blog.content', true);
    $blogElements = getContent('blog.element', limit: 3);
@endphp

<section class="blog-section pb-120">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-heading__title wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                {{ __(@$blogContent->data_values->heading) }}
            </h2>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogElements as $blogElement)
                @include('Template::partials.blog', ['blog' => $blogElement])
            @endforeach
        </div>
    </div>
</section>
