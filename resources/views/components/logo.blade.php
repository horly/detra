@props(['light' => false])
<span {{ $attributes->class(['brand-logo', 'brand-logo-light' => $light]) }}>
    <img src="{{ asset('images/detra-logo.webp') }}" alt="DETRA SARL" width="1536" height="1024">
</span>
