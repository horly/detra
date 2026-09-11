@php
    $locale = app()->getLocale();
    $page = request()->route('page', 'contact');
@endphp
@extends('layouts.site')
@section('content')
<section class="error-page site-container"><p class="eyebrow">429</p><h1>{{ __('site.errors.too_many') }}</h1><p class="body-copy">{{ __('site.errors.too_many_text') }}</p><a href="{{ route($locale.'.'.$page).($page === 'home' ? '#contact' : '') }}" class="button button-copper">{{ __('site.errors.back_contact') }}<x-icon /></a></section>
@endsection
