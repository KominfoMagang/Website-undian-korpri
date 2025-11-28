<nav
    class="fixed top-0 left-0 w-full z-40 flex items-center justify-between px-6 py-4 bg-blue-950/60 backdrop-blur-md border-b border-white/10 transition-all duration-300">

    <div class="flex items-center gap-4">
        <img src="/static/images/bank_bjb.png"
            alt="Logo Bank BJB"
            class="h-10 w-auto drop-shadow-md hover:scale-110 transition-transform duration-200">

        <img src="/static/images/logoKorpri.png" alt="Logo Korpri"
            class="h-10 w-auto drop-shadow-md hover:scale-110 transition-transform duration-200">

        <img src="/static/images/logoKotaTasik.png"
            alt="Logo Kota Tasikmalaya"
            class="h-10 w-auto drop-shadow-md hover:scale-110 transition-transform duration-200">

        <div class="hidden sm:flex flex-col leading-tight">
            <span class="font-bold text-yellow-400 text-xs tracking-widest uppercase">ASN DAY TAHUN 2025</span>
            <span class="font-black text-white text-sm tracking-wider">KOTA TASIKMALAYA</span>
        </div>
    </div>

    <div
        class="absolute left-1/2 transform -translate-x-1/2 flex gap-1 bg-black/20 p-1.5 rounded-full backdrop-blur-md border border-white/10 shadow-lg">

        <a href="{{ route('reward-system.undian') }}" wire:navigate
            @class([ 'px-6 py-2 rounded-full text-sm font-medium transition-all duration-200'
            , 'bg-white text-blue-900 shadow-md font-bold'=> request()->routeIs('reward-system.undian'),
            'text-blue-100 hover:bg-white/10' => !request()->routeIs('reward-system.undian'),
            ])>
            Undian
        </a>

        <a href="{{ route('reward-system.pemenang') }}" wire:navigate
            @class([ 'px-6 py-2 rounded-full text-sm font-medium transition-all duration-200'
            , 'bg-white text-blue-900 shadow-md font-bold'=> request()->routeIs('reward-system.pemenang'),
            'text-blue-100 hover:bg-white/10' => !request()->routeIs('reward-system.pemenang'),
            ])>
            List Pemenang
        </a>

        <a href="{{ route('reward-system.peserta') }}" wire:navigate
            @class([ 'px-6 py-2 rounded-full text-sm font-medium transition-all duration-200'
            , 'bg-white text-blue-900 shadow-md font-bold'=> request()->routeIs('reward-system.peserta'),
            'text-blue-100 hover:bg-white/10' => !request()->routeIs('reward-system.peserta'),
            ])>
            Peserta
        </a>
    </div>

    <button onclick="toggleFullScreen()" id="fsBtn"
        class="group p-2.5 rounded-full bg-white/10 hover:bg-yellow-400 text-white hover:text-blue-900 transition-all border border-white/20 hover:border-yellow-400 shadow-lg"
        title="Full Screen">

        <svg id="iconMax" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
        </svg>

        <svg id="iconMin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</nav>