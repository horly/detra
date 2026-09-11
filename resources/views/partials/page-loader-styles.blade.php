<style>
    #page-loader { position: fixed; inset: 0; z-index: 1000; display: grid; place-items: center; background: #faf9f6; color: #252b2d; opacity: 1; transition: opacity 240ms ease, visibility 240ms ease; }
    #page-loader[hidden] { display: none; }
    #page-loader.is-leaving { opacity: 0; visibility: hidden; pointer-events: none; }
    #page-loader .loader-content { display: flex; flex-direction: column; align-items: center; gap: 30px; padding: 32px; }
    #page-loader .brand-logo { position: relative; display: block; width: 240px; height: 78px; overflow: hidden; mix-blend-mode: multiply; }
    #page-loader .brand-logo img { position: absolute; width: 304px; height: 202.67px; max-width: none; top: -65px; left: -31px; }
    #page-loader .loader-track { width: 150px; height: 2px; overflow: hidden; background: #e5ddd3; }
    #page-loader .loader-track > span { display: block; width: 50%; height: 100%; background: #b67446; animation: detra-loading 1.2s ease-in-out infinite; }
    #page-loader p { margin: -13px 0 0; font: 500 10px/1.7 'Manrope', 'Segoe UI', sans-serif; letter-spacing: .13em; color: #8a7b6b; }
    @keyframes detra-loading { 0% { transform: translateX(-100%); } 100% { transform: translateX(300%); } }
    @media (prefers-reduced-motion: reduce) {
        #page-loader { transition: none; }
        #page-loader .loader-track > span { animation: none; margin: auto; }
    }
    @media print { #page-loader { display: none !important; } }
</style>
