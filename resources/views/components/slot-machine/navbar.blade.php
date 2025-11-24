<nav
    class="fixed top-0 left-0 w-full z-40 flex items-center justify-between px-6 py-4 bg-blue-950/60 backdrop-blur-md border-b border-white/10 transition-all duration-300">
    <div class="flex items-center gap-3">
        <div
            class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-blue-900 border-2 border-white shadow">
            K</div>
        <span class="font-bold text-white tracking-widest text-sm md:text-base hidden sm:block">SISTEM UNDIAN</span>
    </div>

    <div
        class="absolute left-1/2 transform -translate-x-1/2 flex gap-1 bg-black/20 p-1.5 rounded-full backdrop-blur-md border border-white/10 shadow-lg">
        <a href="#" class="nav-link active px-6 py-2 rounded-full text-sm transition-all duration-200">Undian</a>
        <a href="#"
            class="nav-link text-blue-100 px-6 py-2 rounded-full text-sm font-medium transition-all duration-200">List
            Pemenang</a>
        <a href="#"
            class="nav-link text-blue-100 px-6 py-2 rounded-full text-sm font-medium transition-all duration-200">Peserta</a>
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