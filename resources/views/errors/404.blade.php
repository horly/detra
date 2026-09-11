@php
    $locale = request()->segment(1) === 'en' ? 'en' : 'fr';
    app()->setLocale($locale);
    $page = 'home';
@endphp
@extends('layouts.site')
@section('content')
<section class="error-page site-container"><p class="eyebrow">404</p><h1>{{ __('site.errors.not_found') }}</h1><p class="body-copy">{{ __('site.errors.not_found_text') }}</p><a href="{{ route($locale.'.home') }}" class="button button-copper">{{ __('site.common.back_home') }}<x-icon /></a></section>
@endsection
