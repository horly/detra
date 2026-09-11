<div class="hero-controls" data-carousel-controls hidden>
    <div class="carousel-tabs" role="group" aria-label="{{ __('experience.carousel') }}">
        @foreach(__('site.services.items') as $service)
            <button type="button" data-slide-to="{{ $loop->index }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="{{ __('experience.show', ['title' => $service['title']]) }}"><x-icon :name="$service['icon']" /><span>{{ $service['title'] }}</span><small>0{{ $loop->iteration }}</small></button>
        @endforeach
    </div>
    <div class="carousel-navigation">
        <span class="carousel-count"><strong data-slide-count>01</strong> / 03</span>
        <button type="button" class="round-control" data-slide-previous aria-label="{{ __('experience.previous') }}"><x-icon name="previous" /></button>
        <button type="button" class="round-control" data-slide-next aria-label="{{ __('experience.next') }}"><x-icon name="next" /></button>
        <button type="button" class="round-control carousel-play" data-slide-play data-play-label="{{ __('experience.play') }}" data-pause-label="{{ __('experience.pause') }}" aria-label="{{ __('experience.pause') }}"><x-icon name="pause" class="pause-icon" /><x-icon name="play" class="play-icon" /></button>
    </div>
    <span class="sr-only" data-slide-status aria-live="polite"></span>
</div>
