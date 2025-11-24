<div id="dataSection" class="w-full max-w-6xl mx-auto px-4 py-8 pb-12 transition-all duration-500">

    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4 text-white">
        <div>
            <h1 class="text-3xl md:text-4xl font-black mb-1 drop-shadow-md">Data Peserta Undian</h1>
            <p class="text-blue-200 opacity-80">Total Pegawai Terdaftar: <span class="font-bold text-yellow-400">1,245
                    Pegawai</span></p>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
            <select
                class="bg-blue-900/40 border border-blue-400/30 text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none backdrop-blur-md shadow-lg transition hover:bg-blue-900/60 cursor-pointer">
                <option value="" class="text-slate-800">Semua Instansi</option>
                <option value="dinkes" class="text-slate-800">Dinas Kesehatan</option>
                <option value="dikbud" class="text-slate-800">Dinas Pendidikan</option>
                <option value="pupr" class="text-slate-800">Dinas PUPR</option>
                <option value="bappeda" class="text-slate-800">BAPPEDA</option>
            </select>

            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="simple-search"
                    class="bg-blue-900/40 border border-blue-400/30 text-white text-sm rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 block w-full pl-10 p-3 outline-none backdrop-blur-md placeholder-blue-200/70 shadow-lg transition hover:bg-blue-900/60"
                    placeholder="Cari Nama / NIP...">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-white/50 ring-1 ring-slate-900/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead
                    class="bg-slate-50 text-xs uppercase text-slate-500 font-bold tracking-wider border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-5">No</th>
                        <th scope="col" class="px-6 py-5">Pegawai</th>
                        <th scope="col" class="px-6 py-5">Instansi / Unit Kerja</th>
                        <th scope="col" class="px-6 py-5">Golongan</th>
                        <th scope="col" class="px-6 py-5 text-center">Status</th>
                        <th scope="col" class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">

                    <tr class="hover:bg-blue-50/50 transition duration-200 group">
                        <td class="px-6 py-4 font-bold text-slate-400 group-hover:text-blue-500">1</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-110 transition-transform"
                                    src="https://i.pravatar.cc/150?u=1" alt="Avatar">
                                <div>
                                    <div class="font-bold text-slate-800 text-base group-hover:text-blue-700">H. Budi
                                        Santoso, S.Kom</div>
                                    <div
                                        class="text-xs text-slate-500 font-mono tracking-wide bg-slate-100 px-2 py-0.5 rounded inline-block mt-1">
                                        19850320 201001 1 005</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-blue-50 text-blue-700 py-1.5 px-3 rounded-full text-xs font-bold border border-blue-100">BAPPEDA</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-600">III/c</td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                Eligible
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="text-slate-400 hover:text-blue-600 font-bold text-xl leading-none transition">•••</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-50/50 transition duration-200 group">
                        <td class="px-6 py-4 font-bold text-slate-400 group-hover:text-blue-500">2</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-110 transition-transform"
                                    src="https://i.pravatar.cc/150?u=2" alt="Avatar">
                                <div>
                                    <div class="font-bold text-slate-800 text-base group-hover:text-blue-700">Siti
                                        Aminah, M.Si</div>
                                    <div
                                        class="text-xs text-slate-500 font-mono tracking-wide bg-slate-100 px-2 py-0.5 rounded inline-block mt-1">
                                        19901215 201903 2 001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-green-50 text-green-700 py-1.5 px-3 rounded-full text-xs font-bold border border-green-100">Dinas
                                Kesehatan</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-600">III/b</td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                🏆 Menang
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="text-slate-400 hover:text-blue-600 font-bold text-xl leading-none transition">•••</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="bg-slate-50 px-6 py-4 flex items-center justify-between border-t border-slate-200">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Menampilkan <span class="font-bold text-slate-700">1</span> - <span
                            class="font-bold text-slate-700">5</span> dari
                        <span class="font-bold text-slate-700">1,245</span> data
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        <a href="#"
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-slate-400 ring-1 ring-inset ring-slate-300 hover:bg-white focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" aria-current="page"
                            class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:z-20 focus:outline-offset-0">2</a>
                        <a href="#"
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-slate-400 ring-1 ring-inset ring-slate-300 hover:bg-white focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
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

    // Audio Logic
    window.playSoundEffect = function(type) {
        const spinEl = document.getElementById('src-spin');
        const stopEl = document.getElementById('src-stop');
        const winEl  = document.getElementById('src-win');
        if (!spinEl || !stopEl || !winEl) return null;

        let audio;
        if (type === 'spin') {
            audio = new Audio(spinEl.value);
            audio.loop = true;
            audio.volume = 0.6;
        } else if (type === 'stop') {
            audio = new Audio(stopEl.value);
            audio.volume = 1.0;
        } else if (type === 'win') {
            audio = new Audio(winEl.value);
            audio.volume = 1.0;
        }
        if(audio) audio.play().catch(e => console.log("Audio play prevented:", e));
        return audio;
    }

    // Confetti Logic
    window.fireConfetti = function() {
        var duration = 3000; 
        var animationEnd = Date.now() + duration;
        var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 9999 }; 
        var colors = ['#d4af37', '#1e3a8a', '#ef4444', '#ffffff'];
        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();
            if (timeLeft <= 0) return clearInterval(interval);
            var particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: 0.1, y: 0.8 }, colors: colors }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: 0.9, y: 0.8 }, colors: colors }));
        }, 250);
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