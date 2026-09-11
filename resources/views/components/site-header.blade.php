@props(['page'])
@php($locale = app()->getLocale())
<div class="utility-bar corporate-utility">
    <div class="site-container utility-inner">
        <div class="utility-location"><x-icon name="pin" /><span>{{ __('site.common.location') }}</span><span class="utility-tagline">{{ __('site.common.tagline') }}</span></div>
        <div class="utility-contacts">
            @if(config('site.phone'))<a href="tel:{{ preg_replace('/[^+0-9]/', '', config('site.phone')) }}"><x-icon name="phone" /><span>{{ config('site.phone') }}</span></a>@endif
            @if(config('site.email'))<a href="mailto:{{ config('site.email') }}" class="utility-email"><x-icon name="mail" /><span>{{ config('site.email') }}</span></a>@endif
        </div>
    </div>
</div>
<header class="site-header corporate-header">
    <div class="site-container header-inner">
        <a href="{{ route($locale.'.home') }}" class="brand-link header-brand" aria-label="DETRA SARL — {{ __('site.nav.home') }}"><x-logo /></a>
        <nav class="desktop-nav" aria-label="{{ __('site.footer.navigation') }}">
            @foreach(['home', 'about', 'services', 'products', 'commitments'] as $navPage)
                @if($navPage === 'services')<div class="nav-service-group">@endif
                <a href="{{ route($locale.'.'.$navPage) }}" @class(['nav-link', 'is-active' => $page === $navPage]) @if($page === $navPage) aria-current="page" @endif>{{ __('site.nav.'.$navPage) }}</a>
                @if($navPage === 'services')<button type="button" class="nav-service-toggle" aria-expanded="false" aria-controls="services-navigation" aria-label="{{ __('navigation.services_open') }}" data-services-toggle data-open-label="{{ __('navigation.services_open') }}" data-close-label="{{ __('navigation.services_close') }}"><x-icon name="chevron-down" /></button></div>@endif
            @endforeach
        </nav>
        <div class="header-actions flex items-center">
            <nav class="language-switch" aria-label="{{ __('footer.language_label') }}">
                <x-icon name="globe" />
                @foreach(['fr', 'en'] as $language)<a href="{{ route($language.'.'.$page) }}" lang="{{ $language }}" hreflang="{{ $language }}" @class(['is-active' => $locale === $language]) aria-label="{{ $language === 'fr' ? 'Français' : 'English' }}" @if($locale === $language) aria-current="true" @endif>{{ strtoupper($language) }}</a>@endforeach
            </nav>
            <a href="{{ route($locale.'.contact') }}#contact" @class(['button', 'header-contact', 'is-active' => $page === 'contact'])>{{ __('navigation.contact') }}<span><x-icon name="diagonal" /></span></a>
            <button type="button" class="menu-toggle" aria-expanded="false" aria-controls="mobile-navigation" aria-label="{{ __('site.common.open_menu') }}" data-menu-toggle data-open-label="{{ __('site.common.open_menu') }}" data-close-label="{{ __('site.common.close_menu') }}"><x-icon name="menu" /><x-icon name="close" class="close-icon" /></button>
        </div>
    </div>
    <noscript><nav class="mobile-nav-fallback site-container" aria-label="{{ __('site.footer.navigation') }}">@foreach(['home', 'about', 'services', 'products', 'commitments', 'contact'] as $navPage)<a href="{{ route($locale.'.'.$navPage) }}">{{ __('site.nav.'.$navPage) }}</a>@endforeach</nav></noscript>
    <nav id="services-navigation" class="services-navigation" aria-label="{{ __('site.footer.expertise') }}" hidden>
        <div class="site-container services-navigation-grid grid gap-7 lg:grid-cols-[0.9fr_1fr_1fr_1fr]">
            <div class="services-nav-intro"><p class="eyebrow">{{ __('site.footer.expertise') }}</p><h2>{{ __('navigation.solutions') }}</h2><a href="{{ route($locale.'.services') }}" class="text-link">{{ __('site.common.all_services') }}<x-icon /></a></div>
            @foreach(__('site.services.items') as $service)
                <a href="{{ route($locale.'.services') }}#{{ $service['id'] }}" class="services-nav-card"><span class="services-nav-icon"><x-icon :name="$service['icon']" /></span><span><strong>{{ $service['title'] }}</strong><small>{{ $service['short'] }}</small></span><x-icon name="diagonal" /></a>
            @endforeach
        </div>
    </nav>
    <nav id="mobile-navigation" class="mobile-navigation" aria-label="{{ __('site.footer.navigation') }}" hidden>
        <div class="site-container mobile-nav-inner">
            <p class="mobile-nav-label">{{ __('navigation.menu') }}</p>
            <div class="mobile-nav-links">
                @foreach(['home' => 'home', 'about' => 'building', 'services' => 'ship', 'products' => 'droplet', 'commitments' => 'shield', 'contact' => 'message'] as $navPage => $icon)
                    <a href="{{ route($locale.'.'.$navPage) }}" @if($page === $navPage) aria-current="page" @endif><span><x-icon :name="$icon" /></span>{{ __('site.nav.'.$navPage) }}<x-icon name="diagonal" /></a>
                @endforeach
            </div>
            <div class="mobile-nav-contact"><p>{{ __('navigation.direct') }}</p><a href="{{ route($locale.'.contact') }}#contact" class="button button-copper">{{ __('site.common.project') }}<x-icon name="diagonal" /></a><div>@if(config('site.phone'))<a href="tel:{{ preg_replace('/[^+0-9]/', '', config('site.phone')) }}"><x-icon name="phone" />{{ config('site.phone') }}</a>@endif @if(config('site.email'))<a href="mailto:{{ config('site.email') }}"><x-icon name="mail" />{{ config('site.email') }}</a>@endif</div></div>
        </div>
    </nav>
    <div class="navigation-backdrop" data-navigation-backdrop aria-hidden="true" hidden></div>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>
</header>
