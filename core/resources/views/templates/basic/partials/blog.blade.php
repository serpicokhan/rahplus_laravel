<div class="col-lg-4 col-md-6">
    <div class="blog-item">
        <div class="blog-item__date">
            <span class="blog-item__date-number">{{ showDateTime(@$blog->created_at, 'd') }}</span>
            <div class="blog-item__date-monthYear">
                <span class="d-block">{{ showDateTime(@$blog->created_at, 'M') }}</span>
                <span class="d-block">{{ showDateTime(@$blog->created_at, 'Y') }}</span>
            </div>
        </div>
        <h4 class="blog-item__title">
            <a href="{{ route('blog.details', $blog->slug) }}" class="blog-item__title-link border-effect">
                {{ __(strLimit(@$blog->data_values->title, 80)) }}
            </a>
        </h4>
        <p class="blog-item__desc">
            {{ __(strLimit(strip_tags(@$blog->data_values->description), 100)) }}
        </p>
        <a href="{{ route('blog.details', $blog->slug) }}" class="blog-item__thumb">
            <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '415x195') }}" alt="">
        </a>
    </div>
</div>
