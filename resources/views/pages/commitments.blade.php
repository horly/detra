@extends('layouts.site')
@section('content')
<x-page-heading page="commitments" />
<section class="section-space"><div class="site-container"><div class="grid gap-7 md:grid-cols-2">@foreach(__('site.commitments.items') as $commitment)<article class="commitment-card"><div class="flex items-center justify-between"><x-icon :name="$commitment['icon']" class="size-11 text-copper" /><span class="text-sm text-muted">0{{ $loop->iteration }}</span></div><h2>{{ $commitment['title'] }}</h2><p class="body-copy">{{ $commitment['text'] }}</p><ul class="value-list">@foreach($commitment['points'] as $point)<li><x-icon name="check" />{{ $point }}</li>@endforeach</ul></article>@endforeach</div><p class="mt-8 max-w-3xl text-sm leading-6 text-muted">{{ __('site.commitments.note') }}</p></div></section>
<x-cta />
@endsection
