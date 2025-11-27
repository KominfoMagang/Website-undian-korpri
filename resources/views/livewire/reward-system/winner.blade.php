<div class="w-full py-24 pb-40 px-4">
    {{-- CEK: Jika belum ada pemenang sama sekali --}}
    @if($totalPemenang == 0)
    <div class="flex flex-col items-center justify-center min-h-[70vh] w-full">
        <div class="relative">
            <div class="absolute -inset-4 bg-yellow-400/20 rounded-full blur-xl animate-pulse"></div>
            <div class="text-8xl mb-6 relative z-10 animate-bounce">⏳</div>
        </div>
        <h3 class="text-white text-3xl md:text-5xl font-black drop-shadow-lg uppercase tracking-wider text-center">
            Belum Ada Pemenang
        </h3>
        <div class="mt-4 px-6 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
            <p class="text-blue-100 text-lg font-medium tracking-wide">Sistem siap melakukan pengundian</p>
        </div>
    </div>
    @else

    {{-- BAGIAN PODIUM (KHUSUS KATEGORI UTAMA) --}}
    @if($podiumWinners->count() > 0)
    <div class="max-w-5xl mx-auto mb-16">
        <div class="text-center mb-14">
            <h2 class="text-yellow-400 font-black text-3xl uppercase tracking-widest drop-shadow-md">🏆 PEMENANG UTAMA
                🏆</h2>
        </div>

        {{-- Loop Pemenang Utama (Jika ada lebih dari 1, ditampilkan grid) --}}
        <div class="flex flex-wrap justify-center gap-8">
            @foreach($podiumWinners as $juara)
            <div class="flex flex-col items-center animate-float z-10 w-full">
                <div
                    class="relative glass-card w-full rounded-2xl p-8 text-center shadow-[0_20px_50px_rgba(251,191,36,0.3)] border-t-8 border-yellow-400 transform md:scale-105 hover:-translate-y-2 transition-transform duration-300">

                    {{-- Mahkota Icon --}}
                    <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 text-6xl filter drop-shadow-lg">
                        👑
                    </div>

                    <div class="relative w-40 h-40 mx-auto mb-5 mt-4">
                        <div class="absolute -inset-1 bg-yellow-400 rounded-full blur opacity-50 animate-pulse"></div>
                        <div class="relative w-full h-full rounded-full border-4 border-yellow-400 shadow-xl bg-white">
                            <img src="{{ $juara->participant->foto_url }}"
                                class="w-full h-full rounded-full object-cover p-1">
                        </div>
                    </div>

                    <h3 class="text-2xl font-black text-blue-900 leading-tight mb-1">{{ $juara->participant->nama }}
                    </h3>
                    <p class="text-sm font-semibold text-slate-500 mb-4">Kode kupon : {{ $juara->coupon->kode_kupon }}
                    </p>

                    <div
                        class="inline-block bg-yellow-50 text-yellow-800 px-4 py-1.5 rounded-full text-sm font-bold border border-yellow-200 mb-4">
                        {{ $juara->participant->unit_kerja }}
                    </div>

                    <div
                        class="pt-4 border-t border-yellow-100 bg-gradient-to-b from-transparent to-yellow-50/50 rounded-b-xl -mx-8 -mb-8 pb-8 px-4">
                        <p class="text-xs text-yellow-600 uppercase tracking-widest font-bold">Mendapatkan Hadiah</p>
                        <p class="text-xl text-blue-900 font-black mt-1">{{ $juara->reward->nama_hadiah }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- BAGIAN LIST HADIAH UMUM (GRID BAWAH) --}}
    @if($listWinners->count() > 0)
    <div class="max-w-5xl mx-auto mt-12">
        <div class="flex items-center gap-4 mb-8">
            <div class="h-1 flex-1 bg-gradient-to-r from-transparent to-white/50"></div>
            <h2 class="text-white font-bold text-2xl uppercase tracking-wider drop-shadow-md">Pemenang Hadiah Umum</h2>
            <div class="h-1 flex-1 bg-gradient-to-l from-transparent to-white/50"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($listWinners as $winner)
            <div
                class="bg-white/95 backdrop-blur-sm rounded-xl p-4 flex items-center gap-4 shadow-lg border-l-4 border-blue-500 hover:bg-white transition group hover:-translate-y-1">
                <div class="flex-shrink-0">
                    <img src="{{ $winner->participant->foto_url }}"
                        class="w-14 h-14 rounded-full object-cover border-2 border-slate-200 shadow-sm">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-blue-900 font-bold text-sm truncate group-hover:text-blue-600 transition-colors">
                        {{ $winner->participant->nama }}
                    </h4>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-slate-500 font-mono bg-slate-100 px-1.5 rounded">{{
                            $winner->coupon->kode_kupon }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span
                            class="text-[10px] font-semibold bg-blue-50 text-blue-700 px-2 py-0.5 rounded truncate w-fit max-w-full">
                            {{ $winner->participant->unit_kerja }}
                        </span>
                        <span class="text-xs font-bold text-yellow-600 truncate">
                            🎁 {{ $winner->reward->nama_hadiah }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tombol Load More --}}
        @if($hasMore)
        <div class="mt-8 text-center">
            <button wire:click="loadMore" wire:loading.attr="disabled"
                class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-8 rounded-full border border-white/40 transition text-sm cursor-pointer backdrop-blur-md shadow-lg">
                <span wire:loading.remove>Muat Lebih Banyak</span>
                <span wire:loading>Memuat... ⏳</span>
            </button>
        </div>
        @endif
    </div>
    @endif

    @endif

    {{-- Script JS --}}
    @script
    <script>
        window.toggleFullScreen = function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        document.addEventListener('fullscreenchange', (event) => {
            const iconMax = document.getElementById('iconMax');
            const iconMin = document.getElementById('iconMin');
            const navbar  = document.getElementById('mainNavbar');
            const body = document.body;

            if (document.fullscreenElement) {
                body.classList.remove('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');
                if (navbar) navbar.classList.add('hidden');
                if (iconMax && iconMin) { iconMax.classList.add('hidden'); iconMin.classList.remove('hidden'); }
            } else {
                body.classList.add('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');
                if (navbar) navbar.classList.remove('hidden');
                if (iconMax && iconMin) { iconMax.classList.remove('hidden'); iconMin.classList.add('hidden'); }
            }
        });
    </script>
    @endscript
</div>