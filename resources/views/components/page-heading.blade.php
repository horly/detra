@props(['page'])
<section class="page-heading">
    <div class="page-heading-pattern" aria-hidden="true"></div>
    <div class="site-container relative">
        <div class="breadcrumb"><a href="{{ route(app()->getLocale().'.home') }}">{{ __('site.nav.home') }}</a><span>/</span><span>{{ __('site.'.$page.'.eyebrow') }}</span></div>
        <p class="eyebrow">{{ __('site.'.$page.'.eyebrow') }}</p>
        <h1>{{ __('site.'.$page.'.title') }}<br><span class="text-copper">{{ __('site.'.$page.'.accent') }}</span></h1>
        <p class="page-intro">{{ __('site.'.$page.'.intro') }}</p>
    </div>
</section>
