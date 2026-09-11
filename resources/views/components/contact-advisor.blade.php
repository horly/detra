<aside class="contact-advisor" data-reveal>
    <div class="contact-office-visual">
        <img src="{{ asset('images/energy-team.webp') }}" alt="{{ __('experience.team_alt') }}" width="1536" height="1024" loading="lazy">
        <span class="contact-photo-location"><x-icon name="pin" />{{ __('footer.location') }}</span>
        <span class="photo-credit">{{ __('site.common.illustration') }}</span>
    </div>
    <div class="contact-advisor-body">
        <p class="eyebrow">{{ __('contact.team') }}</p>
        <h3>{{ __('contact.team_title') }}<br><span>{{ __('contact.team_accent') }}</span></h3>
        <p class="contact-advisor-intro">{{ __('contact.team_text') }}</p>
        <address class="contact-direct-links">
            @if(config('site.email'))
                <a href="mailto:{{ config('site.email') }}"><span class="contact-action-icon"><x-icon name="mail" /></span><span><small>{{ __('site.contact.email_label') }}</small><strong>{{ config('site.email') }}</strong></span><x-icon name="diagonal" class="contact-action-arrow" /></a>
            @endif
            @if(config('site.phone'))
                <a href="tel:{{ preg_replace('/[^+0-9]/', '', config('site.phone')) }}"><span class="contact-action-icon"><x-icon name="phone" /></span><span><small>{{ __('site.contact.phone_label') }}</small><strong>{{ config('site.phone') }}</strong></span><x-icon name="diagonal" class="contact-action-arrow" /></a>
            @endif
            <a href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode(config('site.address') ?: __('site.common.location')) }}" target="_blank" rel="noopener noreferrer"><span class="contact-action-icon"><x-icon name="pin" /></span><span><small>{{ __('site.contact.location_label') }}</small><span>{{ config('site.address') ?: __('site.common.location') }}</span></span><x-icon name="diagonal" class="contact-action-arrow" /></a>
        </address>
        @if(config('site.website'))
            <a href="{{ config('site.website') }}" class="contact-advisor-website" target="_blank" rel="noopener noreferrer"><x-icon name="globe" />{{ parse_url(config('site.website'), PHP_URL_HOST) }}<x-icon name="diagonal" /></a>
        @endif
    </div>
</aside>
