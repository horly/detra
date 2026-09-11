<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#252b2d">
    <title>{{ __('site.meta.'.$page) }} | DETRA SARL</title>
    <meta name="description" content="{{ __('site.meta.description') }}">
    <link rel="canonical" href="{{ route($locale.'.'.$page) }}">
    @foreach(['fr', 'en'] as $language)
        <link rel="alternate" hreflang="{{ $language }}" href="{{ route($language.'.'.$page) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ route('fr.'.$page) }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DETRA SARL">
    <meta property="og:title" content="{{ __('site.meta.'.$page) }} | DETRA SARL">
    <meta property="og:description" content="{{ __('site.meta.description') }}">
    <meta property="og:url" content="{{ route($locale.'.'.$page) }}">
    <meta property="og:image" content="{{ asset('images/maritime-hero.webp') }}">
    <meta property="og:locale" content="{{ $locale === 'fr' ? 'fr_CD' : 'en_GB' }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preload" as="image" href="{{ asset('images/detra-logo.webp') }}">
    @include('partials.page-loader-styles')
    @if($page === 'home')<link rel="preload" as="image" href="{{ asset('images/maritime-hero.webp') }}">@endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top">
    <x-page-loader />
    <a href="#main" class="skip-link">{{ __('site.common.skip') }}</a>
    <x-site-header :page="$page" />
    <main id="main">@yield('content')</main>
    <x-site-footer :page="$page" />
    <x-quick-contact />
</body>
</html>
