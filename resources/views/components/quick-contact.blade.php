@php($locale = app()->getLocale())
<div class="quick-contact" data-quick-contact hidden>
    <div class="quick-contact-links" id="quick-contact-links" hidden>
        <p>{{ __('experience.quick_contact') }}</p>
        @if(config('site.phone'))<a href="tel:{{ preg_replace('/[^+0-9]/', '', config('site.phone')) }}"><span><x-icon name="phone" /></span>{{ __('experience.call') }}<x-icon name="diagonal" /></a>@endif
        @if(config('site.email'))<a href="mailto:{{ config('site.email') }}"><span><x-icon name="mail" /></span>{{ __('experience.email') }}<x-icon name="diagonal" /></a>@endif
        <a href="https://www.google.com/maps/dir/?api=1&amp;destination={{ rawurlencode(config('site.address') ?: __('site.common.location')) }}" target="_blank" rel="noopener noreferrer"><span><x-icon name="route" /></span>{{ __('experience.directions') }}<x-icon name="diagonal" /></a>
        <a href="{{ route($locale.'.contact') }}#contact"><span><x-icon name="message" /></span>{{ __('experience.quote') }}<x-icon name="arrow" /></a>
    </div>
    <button type="button" class="quick-contact-toggle" aria-expanded="false" aria-controls="quick-contact-links" aria-label="{{ __('experience.quick_contact') }}" data-open-label="{{ __('experience.quick_contact') }}" data-close-label="{{ __('experience.quick_close') }}"><x-icon name="message" class="quick-open-icon" /><x-icon name="close" class="quick-close-icon" /></button>
</div>
