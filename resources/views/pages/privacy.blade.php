@extends('layouts.site')
@section('content')
<x-page-heading page="privacy" />
<section class="section-space"><div class="site-container"><div class="max-w-3xl">@foreach(__('site.privacy.sections') as $section)<article class="privacy-section"><h2>{{ $section['title'] }}</h2><p class="body-copy mt-4">{{ $section['text'] }}</p></article>@endforeach<a href="{{ route($locale.'.contact') }}" class="text-link">{{ __('site.cta.button') }}<x-icon /></a></div></div></section>
@endsection
