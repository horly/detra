<section class="section-space products-preview"><div class="site-container">
    <div class="section-heading flex flex-col justify-between gap-7 md:flex-row md:items-end"><div class="max-w-xl"><p class="eyebrow">{{ __('site.home.products_label') }}</p><h2>{{ __('site.home.products_title') }}</h2></div><a class="text-link" href="{{ route(app()->getLocale().'.products') }}">{{ __('site.common.all_products') }}<x-icon /></a></div>
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach(__('site.products.items') as $product)
            <a href="{{ route(app()->getLocale().'.products') }}#{{ $product['id'] }}" class="product-preview-card">
                <x-product-image :product="$product['id']" />
                <div class="product-preview-content"><p>{{ $product['label'] }}</p><div class="flex items-center justify-between gap-3"><h3>{{ $product['title'] }}</h3><span class="product-preview-arrow"><x-icon name="diagonal" /></span></div></div>
            </a>
        @endforeach
    </div>
    <p class="mt-6 max-w-2xl text-sm leading-6 text-muted">{{ __('site.products.notice') }}</p>
</div></section>
