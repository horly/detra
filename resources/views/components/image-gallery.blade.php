<section class="section-space image-gallery" aria-labelledby="gallery-heading" data-gallery>
    <div class="site-container">
        <div class="section-heading flex flex-col justify-between gap-6 md:flex-row md:items-end"><div class="max-w-2xl"><p class="eyebrow">{{ __('experience.gallery_label') }}</p><h2 id="gallery-heading">{{ __('experience.gallery_title') }}</h2></div><p class="body-copy max-w-sm">{{ __('experience.gallery_text') }}</p></div>
        <div class="gallery-grid">
            @foreach(__('experience.gallery') as $visual)
                <a class="gallery-card" href="{{ asset('images/'.$visual['image']) }}" data-gallery-item data-title="{{ $visual['title'] }}" aria-label="{{ __('experience.enlarge', ['title' => $visual['title']]) }}" data-reveal>
                    <img src="{{ asset('images/'.$visual['image']) }}" alt="{{ $visual['alt'] }}" width="1536" height="1024" loading="lazy">
                    <span class="gallery-topline"><span><x-icon :name="$visual['icon']" />{{ $visual['tag'] }}</span><span class="gallery-zoom"><x-icon name="zoom" /></span></span>
                    <span class="gallery-title">{{ $visual['title'] }}</span>
                </a>
            @endforeach
        </div>
        <p class="gallery-credit">{{ __('site.common.illustration') }}</p>
    </div>
    <dialog class="gallery-dialog" aria-labelledby="lightbox-title">
        <div class="lightbox-toolbar"><p id="lightbox-title"></p><button type="button" class="round-control" data-gallery-close aria-label="{{ __('experience.close') }}"><x-icon name="close" /></button></div>
        <img class="lightbox-image" alt="">
        <div class="lightbox-footer"><span>{{ __('site.common.illustration') }}</span><div class="flex items-center gap-4"><button type="button" class="round-control" data-gallery-previous aria-label="{{ __('experience.previous') }}"><x-icon name="previous" /></button><span data-gallery-count aria-live="polite"></span><button type="button" class="round-control" data-gallery-next aria-label="{{ __('experience.next') }}"><x-icon name="next" /></button></div></div>
    </dialog>
</section>
