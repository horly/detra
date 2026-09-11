<section class="cta-section">
    <div class="site-container flex flex-col items-start justify-between gap-10 lg:flex-row lg:items-center">
        <div class="relative">
            <p class="eyebrow">{{ __('site.cta.eyebrow') }}</p>
            <h2>{{ __('site.cta.title') }}<br>{{ __('site.cta.accent') }}</h2>
            <p class="mt-5 max-w-lg text-white/80">{{ __('site.cta.text') }}</p>
        </div>
        <a class="button button-white relative" href="{{ route(app()->getLocale().'.contact') }}">{{ __('site.cta.button') }}<x-icon name="diagonal" /></a>
    </div>
</section>
