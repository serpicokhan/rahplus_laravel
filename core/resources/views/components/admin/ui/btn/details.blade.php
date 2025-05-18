@props(['tag' => 'a', 'text' => 'Details'])

@if ($tag == 'a')
    <a {{ $attributes->merge(['class' => 'btn  btn-outline--primary']) }}>
        <i class="las la-info-circle me-1"></i>
        {{ __($text) }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => 'btn  btn-outline--primary details-btn']) }}>
        <i class="las la-info-circle me-1"></i>
        {{ __($text) }}
    </button>
@endif
