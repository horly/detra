@props(['name' => 'arrow'])
<svg {{ $attributes->merge(['class' => 'icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('arrow') <path d="M4 12h15m-6-6 6 6-6 6"/> @break
        @case('diagonal') <path d="M6 18 18 6M6 6h12v12"/> @break
        @case('down') <path d="M12 4v16m-6-6 6 6 6-6"/> @break
        @case('pin') <path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/> @break
        @case('globe') <circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18M5 6.5h14M5 17.5h14"/> @break
        @case('ship') <path d="m3 13 9-4 9 4-3 6M3 13l3 6m1-7V5h10v7M10 5V2h4v3M2 21c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2M12 9v9"/> @break
        @case('droplet') <path d="M12 2S4 11 4 15a8 8 0 0 0 16 0c0-4-8-13-8-13Z"/><path d="M8 15a4 4 0 0 0 4 4"/> @break
        @case('truck') <path d="M2 5h12v12H2V5Zm12 4h4l4 4v4h-8M18 9v5h4"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/> @break
        @case('shield') <path d="m12 2 8 3v6c0 5-8 11-8 11S4 16 4 11V5l8-3Z"/><path d="m8 11 3 3 5-5"/> @break
        @case('check') <path d="m5 12 4 4L19 6"/> @break
        @case('leaf') <path d="M20 3S3 1 3 13a7 7 0 0 0 7 7C22 20 20 3 20 3ZM3 22 15 10"/> @break
        @case('handshake') <path d="m2 7 4-3 5 3m11 0-4-3-5 2-4 5 2 2 5-4 5 5-6 7-9-7-4 2M1 6l4 10M23 6l-4 10m-9-1 4 4m-1-7 4 4"/> @break
        @case('mail') <rect x="2" y="4" width="20" height="16" rx="1"/><path d="m2 5 10 8L22 5"/> @break
        @case('phone') <path d="m7 3 3 5-3 3c1 3 3 5 6 6l3-3 5 3-1 4C10 23 1 14 3 4l4-1Z"/> @break
        @case('menu') <path d="M4 6h16M4 12h16M4 18h16"/> @break
        @case('close') <path d="m6 6 12 12M6 18 18 6"/> @break
        @case('previous') <path d="m14 5-7 7 7 7"/> @break
        @case('next') <path d="m10 5 7 7-7 7"/> @break
        @case('play') <path d="m8 4 12 8-12 8V4Z"/> @break
        @case('pause') <path d="M8 5v14M16 5v14"/> @break
        @case('zoom') <circle cx="10" cy="10" r="6"/><path d="m15 15 6 6M7 10h6M10 7v6"/> @break
        @case('copy') <rect x="8" y="8" width="12" height="13" rx="2"/><path d="M16 8V3H3v13h5"/> @break
        @case('route') <circle cx="5" cy="18" r="3"/><path d="M5 15V8a3 3 0 0 1 3-3h11m-4-4 4 4-4 4M12 18h8"/> @break
        @case('message') <path d="M21 11a9 9 0 0 1-9 9H3l2-5a9 9 0 1 1 16-4Z"/><path d="M8 9h8M8 13h5"/> @break
        @case('user') <circle cx="12" cy="7" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/> @break
        @case('building') <path d="M4 21V3h11v18M15 10h5v11M2 21h20M8 7h3M8 11h3M8 15h3M9 21v-3"/> @break
        @case('chevron-down') <path d="m6 9 6 6 6-6"/> @break
        @case('home') <path d="m3 10 9-7 9 7M5 9v12h14V9M9 21v-8h6v8"/> @break
    @endswitch
</svg>
