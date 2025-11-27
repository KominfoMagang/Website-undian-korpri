<div id="dataSection" class="w-full max-w-6xl mx-auto px-4 py-8 pb-12 transition-all duration-500">

    {{-- HEADER & STATISTIK --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4 text-white">
        <div>
            <h1 class="text-3xl md:text-4xl font-black mb-1 drop-shadow-md">Data Peserta Undian</h1>
            <div class="flex gap-4 text-sm md:text-base">
                <p class="text-blue-200 opacity-80">Total: <span class="font-bold text-yellow-400">{{
                        number_format($totalPeserta) }}</span></p>
                <p class="text-blue-200 opacity-80">Hadir: <span class="font-bold text-green-400">{{
                        number_format($totalHadir) }}</span></p>
            </div>
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
            {{-- Filter Instansi --}}
            <select wire:model.live="instansi" class="bg-blue-900/40 border border-blue-400/30 text-white text-sm rounded-xl px-4 py-3 
           focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none 
           backdrop-blur-md shadow-lg transition cursor-pointer
           max-w-[200px] md:max-w-xs truncate pr-8">

                <option value="" class="text-slate-800">Semua Instansi</option>
                @foreach($unitKerjaList as $unit)
                <option value="{{ $unit }}" class="text-slate-800">{{ $unit }}</option>
                @endforeach
            </select>

            {{-- Input Pencarian --}}
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="bg-blue-900/40 border border-blue-400/30 text-white text-sm rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 block w-full pl-10 p-3 outline-none backdrop-blur-md placeholder-blue-200/70 shadow-lg transition"
                    placeholder="Cari Nama / NIP...">
            </div>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-white/50 ring-1 ring-slate-900/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead
                    class="bg-slate-50 text-xs uppercase text-slate-500 font-bold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-5">No</th>
                        <th class="px-6 py-5">Pegawai</th>
                        <th class="px-6 py-5">Instansi / Unit Kerja</th>
                        <th class="px-6 py-5 text-center">Status Hadir</th>
                        <th class="px-6 py-5 text-center">Status Undian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($participants as $index => $p)
                    <tr class="hover:bg-blue-50/50 transition duration-200 group">
                        {{-- Nomor Urut (Sesuai Pagination) --}}
                        <td class="px-6 py-4 font-bold text-slate-400 group-hover:text-blue-500">
                            {{ $participants->firstItem() + $index }}
                        </td>

                        {{-- Info Pegawai --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                {{-- Avatar / Foto --}}
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md"
                                    src="{{ $p->foto_url }}"
                                    alt="{{ $p->nama }}">
                                <div>
                                    <div class="font-bold text-slate-800 text-base group-hover:text-blue-700">{{
                                        $p->nama }}</div>
                                    <div
                                        class="text-xs text-slate-500 font-mono tracking-wide bg-slate-100 px-2 py-0.5 rounded inline-block mt-1">
                                        {{ $p->nip }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Instansi --}}
                        <td class="px-6 py-4">
                            <span
                                class="bg-blue-50 text-blue-700 py-1.5 px-3 rounded-full text-xs font-bold border border-blue-100 inline-block max-w-[150px] truncate align-middle"
                                title="{{ $p->unit_kerja }}">
                                {{ $p->unit_kerja }}
                            </span>
                        </td>

                        {{-- Status Kehadiran --}}
                        <td class="px-6 py-4 text-center">
                            @if($p->status_hadir == 'Hadir')
                            <span
                                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                Hadir
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                Tidak Hadir
                            </span>
                            @endif
                        </td>

                        {{-- Status Undian (Menang/Belum) --}}
                        <td class="px-6 py-4 text-center">
                            @if($p->sudah_menang)
                            <span
                                class="inline-flex items-center gap-1 py-1 px-2.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                🏆 Menang
                            </span>
                            @else
                            <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">
                            Data tidak ditemukan...
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
            {{ $participants->links() }}
        </div>
    </div>
    @script
    <script>
        // --- 1. FUNGSI UTILS ---
    
    // Toggle Fullscreen Pemicu Tombol
    window.toggleFullScreen = function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
        }
    }

    // --- 2. LISTENER UI (YANG DIPERBAIKI) ---
    document.addEventListener('fullscreenchange', (event) => {
        const iconMax = document.getElementById('iconMax');
        const iconMin = document.getElementById('iconMin');
        const navbar  = document.getElementById('mainNavbar');
        const container = document.getElementById('gameContainer'); // Slot Machine
        const dataSection = document.getElementById('dataSection'); // Tabel Data
        const body = document.body;

        if (document.fullscreenElement) {
            // === MASUK MODE FULLSCREEN ===
            
            // 1. Matikan Padding Body biar lega
            body.classList.remove('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');
            
            // 2. Sembunyikan Navbar saja (TABEL TETAP MUNCUL)
            if (navbar) navbar.classList.add('hidden');
            
            // 3. Ganti Icon
            if (iconMax && iconMin) { 
                iconMax.classList.add('hidden'); 
                iconMin.classList.remove('hidden'); 
            }

            // 4. Perbesar Slot Machine jadi Full Layar
            if (container) {
                container.classList.remove('max-w-6xl', 'rounded-3xl', 'border-4', 'shadow-2xl', 'min-h-[600px]');
                container.classList.add('w-screen', 'h-screen', 'rounded-none', 'border-0');
                container.style.width = "100vw";
                container.style.height = "100vh";
                container.style.maxWidth = "100%";
                container.style.margin = "0";
            }
            
            // 5. Atur Tabel (Opsional: kasih margin atas biar ga ketabrak Slot)
            if (dataSection) {
                // Pastikan tabel TIDAK disembunyikan
                dataSection.classList.remove('hidden'); 
                // Kasih jarak sedikit kalau perlu
                dataSection.classList.add('mt-10'); 
            }

        } else {
            // === KELUAR MODE FULLSCREEN ===

            // 1. Balikin Padding Body
            body.classList.add('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');

            // 2. Munculkan Navbar
            if (navbar) navbar.classList.remove('hidden');

            // 3. Balikin Icon
            if (iconMax && iconMin) { 
                iconMax.classList.remove('hidden'); 
                iconMin.classList.add('hidden'); 
            }

            // 4. Kecilkan Slot Machine
            if (container) {
                container.classList.add('max-w-6xl', 'rounded-3xl', 'border-4', 'shadow-2xl', 'min-h-[600px]');
                container.classList.remove('w-screen', 'h-screen', 'rounded-none', 'border-0');
                container.style.width = "";
                container.style.height = "";
                container.style.maxWidth = "";
                container.style.margin = "";
            }

             // 5. Balikin Tabel Normal
             if (dataSection) {
                dataSection.classList.remove('mt-10');
            }
        }
    });
    </script>
    @endscript
</div>