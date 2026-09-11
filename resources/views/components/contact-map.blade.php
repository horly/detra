@php
    $query = rawurlencode(config('site.address') ?: __('site.common.location'));
@endphp
<div class="contact-map" data-reveal>
    <div class="map-information">
        <span class="map-location-icon"><x-icon name="pin" /></span>
        <p class="eyebrow">{{ __('experience.map_label') }}</p>
        <h3>{{ __('experience.map_title') }}</h3>
        <p class="map-address">{{ config('site.address') ?: __('site.common.location') }}</p>
        <a href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $query }}" class="text-link" target="_blank" rel="noopener noreferrer"><x-icon name="route" />{{ __('experience.directions') }}</a>
        <button type="button" class="text-link copy-address" data-copy-address="{{ config('site.address') ?: __('site.common.location') }}" data-success="{{ __('experience.copied') }}" data-failure="{{ __('experience.copy_failed') }}" hidden><x-icon name="copy" />{{ __('experience.copy') }}</button>
        <p class="copy-status" data-copy-status aria-live="polite"></p>
    </div>
    <div class="map-visual">
        <iframe src="https://maps.google.com/maps?q={{ $query }}&amp;hl={{ app()->getLocale() }}&amp;z=15&amp;output=embed" title="{{ __('experience.map_frame') }}" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <div class="map-caption"><p>{{ __('experience.map_note') }}</p><a href="https://www.google.com/maps/search/?api=1&amp;query={{ $query }}" target="_blank" rel="noopener noreferrer">{{ __('experience.open_map') }}<x-icon name="diagonal" /></a></div>
    </div>
</div>
