@extends('layouts.site')
@section('content')
<x-page-heading page="products" />
<section class="section-space"><div class="site-container" data-product-catalog>
    <div class="catalog-toolbar flex flex-wrap items-center justify-between gap-5"><div class="product-filters flex flex-wrap gap-2" role="group" aria-label="{{ __('site.nav.products') }}"><button type="button" data-product-filter="all" aria-pressed="true">{{ __('site.products.all') }}</button><button type="button" data-product-filter="fuel" aria-pressed="false">{{ __('site.products.fuel') }}</button><button type="button" data-product-filter="industry" aria-pressed="false">{{ __('site.products.industry') }}</button></div><span class="text-sm text-muted" data-product-count data-count-label="{{ __('site.products.count', ['count' => '{count}']) }}" aria-live="polite">{{ __('site.products.count', ['count' => 4]) }}</span></div>
    <div class="grid gap-7 md:grid-cols-2">
        @foreach(__('site.products.items') as $product)
            <article class="product-card" id="{{ $product['id'] }}" data-product-category="{{ $product['category'] }}">
                <x-product-image :product="$product['id']" />
                <div class="product-card-content">
                    <div class="product-card-top"><div><p class="eyebrow">{{ $product['label'] }}</p><h2>{{ $product['title'] }}</h2></div><span class="product-mark" aria-hidden="true">{{ $product['symbol'] }}<x-icon name="droplet" /></span></div>
                    <p class="body-copy mt-5">{{ $product['text'] }}</p><p class="product-uses">{{ $product['uses'] }}</p><a href="{{ route($locale.'.contact', ['service' => 'supply', 'product' => $product['id']]) }}" class="text-link">{{ __('site.products.request') }}<x-icon /></a>
                </div>
            </article>
        @endforeach
    </div>
    <p class="catalog-notice"><x-icon name="droplet" class="shrink-0" />{{ __('site.products.notice') }}</p>
    <div class="custom-product flex flex-col justify-between gap-7 md:flex-row md:items-center"><div><h2>{{ __('site.products.custom_title') }}</h2><p class="body-copy mt-3">{{ __('site.products.custom_text') }}</p></div><a class="button button-dark shrink-0" href="{{ route($locale.'.contact') }}">{{ __('site.common.quote') }}<x-icon name="diagonal" /></a></div>
</div></section>
<x-cta />
@endsection
