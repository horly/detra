@props(['page'])
@php($locale = app()->getLocale())
<footer id="footer" class="site-footer corporate-footer">
    <div class="footer-pattern" aria-hidden="true"></div>
    <div class="site-container footer-inner">
        <div class="footer-connect flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
            <div><p class="eyebrow">{{ __('footer.eyebrow') }}</p><h2>{{ __('footer.title') }}<br><span>{{ __('footer.accent') }}</span></h2></div>
            <div class="footer-connect-action">
                <a href="{{ route($locale.'.contact') }}#contact" class="button footer-project-link">{{ __('footer.cta') }}<span><x-icon name="diagonal" /></span></a>
                <p><x-icon name="globe" />{{ __('footer.languages') }}</p>
            </div>
        </div>
        <div class="footer-content-grid grid grid-cols-2 gap-x-10 gap-y-12 lg:grid-cols-[1.15fr_0.7fr_0.95fr_1.2fr]">
            <div class="footer-brand col-span-2 sm:col-span-1">
                <a href="{{ route($locale.'.home') }}" class="brand-link" aria-label="DETRA SARL — {{ __('site.nav.home') }}"><x-logo light /></a>
                <p class="footer-description">{{ __('site.footer.description') }}</p>
                <div class="footer-origin"><span><x-icon name="globe" /></span><div><strong>{{ __('footer.location') }}</strong><p>{{ __('site.footer.made') }}</p></div></div>
                <p class="footer-trade">{{ __('footer.trade') }}</p>
            </div>
            <nav aria-label="{{ __('site.footer.navigation') }}">
                <h2 class="footer-column-title">{{ __('site.footer.navigation') }}</h2>
                <div class="footer-nav-list">
                    @foreach(['home', 'about', 'products', 'commitments', 'contact'] as $navPage)
                        <a href="{{ route($locale.'.'.$navPage) }}" @if($page === $navPage) aria-current="page" @endif>{{ __('site.nav.'.$navPage) }}<x-icon name="diagonal" /></a>
                    @endforeach
                </div>
            </nav>
            <nav aria-label="{{ __('site.footer.expertise') }}">
                <h2 class="footer-column-title">{{ __('site.footer.expertise') }}</h2>
                <div class="footer-nav-list">
                    @foreach(__('site.services.items') as $service)
                        <a href="{{ route($locale.'.services') }}#{{ $service['id'] }}">{{ $service['title'] }}<x-icon name="diagonal" /></a>
                    @endforeach
                </div>
                <a href="{{ route($locale.'.services') }}" class="footer-all-services">{{ __('site.common.all_services') }}<x-icon name="arrow" /></a>
            </nav>
            <div class="footer-contact-card col-span-2 sm:col-span-1">
                <h2>{{ __('footer.contact_title') }}</h2>
                <address>
                    @if(config('site.email'))
                        <a href="mailto:{{ config('site.email') }}"><span class="footer-contact-icon"><x-icon name="mail" /></span><span><small>{{ __('footer.email_label') }}</small><strong>{{ config('site.email') }}</strong></span></a>
                    @endif
                    @if(config('site.phone'))
                        <a href="tel:{{ preg_replace('/[^+0-9]/', '', config('site.phone')) }}"><span class="footer-contact-icon"><x-icon name="phone" /></span><span><small>{{ __('footer.phone_label') }}</small><strong>{{ config('site.phone') }}</strong></span></a>
                    @endif
                    <a href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode(config('site.address') ?: __('site.common.location')) }}" target="_blank" rel="noopener noreferrer"><span class="footer-contact-icon"><x-icon name="pin" /></span><span><small>{{ __('footer.address_label') }}</small><span>{{ config('site.address') ?: __('site.common.location') }}</span></span></a>
                </address>
                @if(config('site.website'))<a href="{{ config('site.website') }}" class="footer-website" target="_blank" rel="noopener noreferrer">{{ parse_url(config('site.website'), PHP_URL_HOST) }}<x-icon name="diagonal" /></a>@endif
            </div>
        </div>
        <div class="footer-legal flex flex-wrap items-center justify-between gap-x-8 gap-y-5">
            <p>© {{ date('Y') }} <strong>DETRA SARL.</strong> {{ __('site.footer.rights') }}</p>
            <div class="footer-legal-actions flex flex-wrap items-center gap-x-7 gap-y-5">
                <a href="{{ route($locale.'.privacy') }}">{{ __('site.footer.privacy') }}</a>
                <nav class="footer-languages" aria-label="{{ __('footer.language_label') }}">
                    @foreach(['fr', 'en'] as $language)<a href="{{ route($language.'.'.$page) }}" lang="{{ $language }}" hreflang="{{ $language }}" aria-label="{{ $language === 'fr' ? 'Français' : 'English' }}" @if($locale === $language) aria-current="true" @endif>{{ strtoupper($language) }}</a>@endforeach
                </nav>
                <a href="#top" class="footer-back-top">{{ __('footer.back_top') }}<span><x-icon name="arrow" /></span></a>
            </div>
        </div>
    </div>
</footer>
