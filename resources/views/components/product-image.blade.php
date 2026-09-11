@props(['product'])
@php($visual = __('experience.product_images.'.$product))
<div class="product-photo"><img src="{{ asset('images/'.$visual['image']) }}" alt="{{ $visual['alt'] }}" loading="lazy" width="1536" height="1024"><span class="photo-credit">{{ __('site.common.illustration') }}</span></div>
