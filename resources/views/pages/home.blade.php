@extends('layouts.site')
@section('content')
<section class="hero" data-carousel aria-label="{{ __('experience.carousel') }}">
    @foreach(__('site.services.items') as $service)
        <img @class(['hero-image', 'is-active' => $loop->first]) src="{{ asset('images/'.$service['image']) }}" alt="{{ $service['alt'] }}" width="1672" height="941" @if($loop->first) fetchpriority="high" @else fetchpriority="low" aria-hidden="true" @endif data-slide data-title="{{ $service['title'] }}">
    @endforeach
    <div class="hero-shade"></div>
    <div class="site-container hero-content">
        <div class="hero-copy">
            <p class="eyebrow hero-eyebrow"><span></span>{{ __('site.home.eyebrow') }}</p>
            <h1><span class="hero-line">{{ __('site.home.title') }}</span><span class="hero-line">{{ __('site.home.title_second') }}</span><span class="hero-line hero-accent">{{ __('site.home.title_accent') }}</span></h1>
            <p class="hero-description">{{ __('site.home.description') }}</p>
            <div class="hero-buttons flex flex-wrap items-center gap-x-7 gap-y-5"><a href="{{ route($locale.'.services') }}" class="button button-copper">{{ __('site.common.discover') }}<x-icon /></a><a href="#contact" class="hero-text-link">{{ __('site.common.project') }}<x-icon name="diagonal" /></a></div>
        </div>
        <div class="hero-footer"><x-hero-controls /></div>
    </div>
    <span class="hero-image-credit">{{ __('site.common.illustration') }}</span>
</section>
<section class="expertise-strip">
    <div class="site-container grid md:grid-cols-3">
        @foreach(__('site.services.items') as $service)
            <a href="{{ route($locale.'.services') }}#{{ $service['id'] }}" class="strip-item group"><x-icon :name="$service['icon']" class="strip-icon" /><div><h2>{{ $service['title'] }}</h2><p>{{ $service['short'] }}</p></div><x-icon name="diagonal" class="strip-arrow" /></a>
        @endforeach
    </div>
</section>
<section id="expertise" class="section-space">
    <div class="site-container">
        <div class="section-heading flex flex-col justify-between gap-7 md:flex-row md:items-end"><div><p class="eyebrow">{{ __('site.home.expertise_label') }}</p><h2>{{ __('site.home.expertise_title') }}<br><span class="text-muted">{{ __('site.home.expertise_accent') }}</span></h2></div><div class="max-w-sm"><p class="body-copy">{{ __('site.home.expertise_text') }}</p><a class="text-link mt-5" href="{{ route($locale.'.services') }}">{{ __('site.common.all_services') }}<x-icon /></a></div></div>
        <div class="grid gap-7 md:grid-cols-3">
            @foreach(__('site.services.items') as $service)
                <a href="{{ route($locale.'.services') }}#{{ $service['id'] }}" class="service-card group"><div class="service-image"><img src="{{ asset('images/'.$service['image']) }}" alt="{{ $service['alt'] }}" loading="lazy" width="768" height="512"><span class="service-number">0{{ $loop->iteration }}</span></div><div class="service-card-content"><h3>{{ $service['title'] }}</h3><p>{{ $service['description'] }}</p><span class="card-link">{{ __('site.common.more') }}<x-icon name="diagonal" /></span></div></a>
            @endforeach
        </div>
    </div>
</section>
<section class="about-section section-space">
    <div class="site-container grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
        <div class="about-visual"><img src="{{ asset('images/storage-terminal.webp') }}" alt="{{ __('site.services.items.1.alt') }}" loading="lazy" width="768" height="512"><div class="location-card"><x-icon name="globe" class="size-10" /><div><strong>Kinshasa</strong><span>{{ __('site.footer.made') }}</span></div></div><span class="photo-credit">{{ __('site.common.illustration') }}</span></div>
        <div><p class="eyebrow">{{ __('site.home.about_label') }}</p><h2>{{ __('site.home.about_title') }}<br>{{ __('site.home.about_accent') }}</h2><p class="body-copy mt-6">{{ __('site.home.about_text') }}</p><ul class="value-list">@foreach(__('site.home.values') as $value)<li><x-icon name="check" />{{ $value }}</li>@endforeach</ul><a href="{{ route($locale.'.about') }}" class="text-link">{{ __('site.home.about_link') }}<x-icon /></a></div>
    </div>
</section>
<x-product-preview />
<x-image-gallery />
<section class="commitment-banner"><div class="site-container flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center"><div class="flex items-start gap-6"><x-icon name="shield" class="size-12 shrink-0 text-copper-light" /><div><p class="eyebrow">{{ __('site.home.commitment_label') }}</p><h2>{{ __('site.home.commitment_title') }}</h2><p class="mt-4 max-w-2xl text-white/65">{{ __('site.home.commitment_text') }}</p></div></div><a href="{{ route($locale.'.commitments') }}" class="text-link light">{{ __('site.home.commitment_link') }}<x-icon /></a></div></section>
<x-contact-section source="home" />
@endsection
