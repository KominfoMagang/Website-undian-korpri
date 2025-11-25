<div>
    <input type="hidden" id="src-spin" value="https://assets.mixkit.co/active_storage/sfx/2065/2065-preview.mp3">
    <input type="hidden" id="src-stop" value="https://assets.mixkit.co/active_storage/sfx/2578/2578-preview.mp3">
    <input type="hidden" id="src-win" value="https://assets.mixkit.co/active_storage/sfx/2000/2000-preview.mp3">

    <div id="gameContainer"
        class="bg-white rounded-3xl shadow-2xl w-full max-w-6xl overflow-hidden flex flex-col md:flex-row min-h-[600px] border-4 border-yellow-500 relative z-10 transition-all duration-700 ease-in-out">

        <div class="w-full md:w-1/3 bg-slate-50 p-6 flex flex-col border-r-4 border-slate-200">
            <h2
                class="text-xl font-bold text-blue-900 mb-2 uppercase border-b-2 border-yellow-400 inline-block self-start">
                Hadiah Utama</h2>

            <select id="prizeSelect" onchange="changePrize()"
                class="mb-4 w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 font-bold text-blue-900 focus:border-yellow-400 focus:ring-yellow-400 cursor-pointer shadow-sm">
                @foreach($jsRewards as $id => $data)
                <option value="{{ $id }}">{{ $data['nama_hadiah'] }}</option>
                @endforeach
            </select>

            <div
                class="flex-1 bg-white rounded-2xl border-2 border-slate-100 p-6 flex flex-col items-center justify-center relative overflow-hidden group shadow-inner">
                <div id="outOfStockLabel"
                    class="hidden absolute inset-0 z-20 flex items-center justify-center bg-black/10 backdrop-blur-[2px]">
                    <div
                        class="bg-red-600 text-white font-black text-2xl px-6 py-2 rounded transform -rotate-12 border-4 border-white shadow-xl">
                        HABIS / SOLD OUT
                    </div>
                </div>

                <img id="prizeImage" src=""
                    class="relative z-10 max-w-full max-h-56 object-contain transition-all duration-500 drop-shadow-xl">

                <div class="mt-6 flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Ketersediaan:</span>
                    <span id="stockBadge"
                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-lg font-bold border border-green-200 shadow-sm">
                        Sisa: 5
                    </span>
                </div>
            </div>
            <div class="mt-4 text-center">
                <p id="prizeNameDisplay" class="text-xl font-black text-blue-900 leading-tight">Nama Hadiah</p>
            </div>
        </div>

        <div
            class="w-full md:w-2/3 bg-gradient-to-br from-blue-600 to-blue-800 p-8 flex flex-col items-center justify-center relative">

            <div class="text-center mb-10 z-10">
                <span class="text-blue-200 font-semibold tracking-[0.5em] uppercase text-sm">Nomor Pemenang</span>
                <div class="w-16 h-1 bg-yellow-400 mx-auto mt-2 rounded-full"></div>
            </div>

            <div wire:ignore
                class="flex items-center gap-2 md:gap-3 mb-12 p-6 bg-blue-900/50 rounded-2xl border border-blue-400/30 backdrop-blur-sm shadow-2xl">
                <div id="slot-0"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
                <div id="slot-1"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
                <div id="slot-2"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
                <div class="text-yellow-400 text-4xl md:text-6xl font-bold opacity-80">-</div>
                <div id="slot-3"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
                <div id="slot-4"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
                <div id="slot-5"
                    class="slot-box w-14 h-20 md:w-20 md:h-28 flex items-center justify-center text-5xl md:text-7xl font-black text-slate-800 rounded-xl">
                    0</div>
            </div>

            <div class="flex gap-6 z-10">
                <button id="btnStart" onclick="startSpin()"
                    class="btn-action group relative px-8 py-4 bg-gradient-to-b from-green-400 to-green-600 rounded-full shadow-[0_10px_0_rgb(21,128,61)] active:shadow-[0_2px_0_rgb(21,128,61)] active:translate-y-2 transition-all disabled:from-slate-400 disabled:to-slate-500 disabled:shadow-none disabled:translate-y-2 disabled:cursor-not-allowed">
                    <span
                        class="text-white font-black text-xl md:text-2xl uppercase tracking-wider flex items-center gap-2 cursor-pointer">⚙️
                        Mulai Acak</span>
                </button>
                <button id="btnStop" onclick="stopSpinSequence()" disabled
                    class="btn-action px-8 py-4 bg-gradient-to-b from-red-500 to-red-700 rounded-full shadow-[0_10px_0_rgb(153,27,27)] active:shadow-[0_2px_0_rgb(153,27,27)] active:translate-y-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="text-white font-black text-xl md:text-2xl uppercase tracking-wider">✋ STOP!</span>
                </button>
            </div>

            <p id="msgStockEmpty"
                class="hidden text-red-200 font-bold mt-4 bg-red-900/50 px-4 py-2 rounded-lg border border-red-500">
                ⚠️ Stok hadiah ini sudah habis. Silakan pilih hadiah lain.
            </p>
        </div>
    </div>

    <div id="winnerModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-blue-950/90 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div
                    class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border-[6px] border-yellow-400 animate-pop">

                    <div
                        class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-6 text-center border-b-4 border-yellow-500">
                        <h3 class="text-3xl font-black text-yellow-300 uppercase tracking-widest drop-shadow-md">🎉
                            SELAMAT! 🎉</h3>
                    </div>

                    <div class="bg-white px-6 pt-8 pb-6 flex flex-col items-center">
                        <div class="relative mb-6">
                            <img id="winnerPhoto" src=""
                                class="relative w-40 h-40 rounded-full border-4 border-white object-cover shadow-xl">
                            <div
                                class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-blue-800 text-yellow-400 text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider shadow border border-yellow-500 whitespace-nowrap">
                                Winner</div>
                        </div>

                        <div class="text-center w-full">
                            <h2 id="winnerName" class="text-2xl font-black text-slate-800 leading-tight mb-2 uppercase">
                                Nama Pemenang</h2>
                            <div
                                class="inline-block bg-slate-100 px-4 py-2 rounded-lg border border-slate-300 mb-2 shadow-sm">
                                <p id="winnerNip" class="font-mono text-lg text-slate-700 font-bold tracking-widest">
                                    NIP: 123456</p>
                            </div>
                            <p id="winnerAgency" class="text-blue-600 font-bold text-lg mb-6">Dinas Instansi Terkait</p>
                        </div>

                        <div class="w-full bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 text-center mb-2">
                            <span class="text-xs uppercase text-yellow-800 font-bold tracking-wide">Berhak Mendapatkan
                                Hadiah</span>
                            <div id="winnerPrize" class="text-xl font-black text-yellow-600 mt-1">Sepeda Gunung</div>
                            <div class="text-xs text-slate-400 mt-1" id="modalStockInfo">Info stok</div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row gap-3 border-t border-slate-200">
                        <button type="button" onclick="confirmWinner()"
                            class="flex-1 inline-flex justify-center items-center rounded-xl bg-gradient-to-b from-green-500 to-green-600 px-4 py-3 text-sm font-bold text-white shadow hover:from-green-600 hover:to-green-700 focus:outline-none transform hover:-translate-y-0.5 transition w-full">
                            <span class="mr-2">✓</span> Tetapkan Pemenang
                        </button>
                        <button type="button" onclick="cancelWinner()"
                            class="flex-1 inline-flex justify-center items-center rounded-xl bg-white border-2 border-slate-300 px-4 py-3 text-sm font-bold text-slate-600 shadow-sm hover:bg-slate-50 hover:text-red-600 hover:border-red-200 focus:outline-none transition w-full">
                            <span class="mr-2">✕</span> Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // ==========================================
    // 1. UTILITIES (Audio, Confetti, Toggle)
    // ==========================================

    // Fungsi Pemicu Tombol Fullscreen Navbar
    window.toggleFullScreen = function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
        }
    }

    // Fungsi Audio Player
    window.playSoundEffect = function(type) {
        const spinEl = document.getElementById('src-spin');
        const stopEl = document.getElementById('src-stop');
        const winEl  = document.getElementById('src-win');
        
        // Safety Check
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
        
        if(audio) {
            audio.play().catch(e => console.log("Audio play prevented (Browser Policy):", e));
        }
        return audio;
    }

    // Fungsi Confetti (Hujan Kertas)
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

    // ==========================================
    // 2. LISTENER TAMPILAN (FULLSCREEN UI)
    // ==========================================
    document.addEventListener('fullscreenchange', (event) => {
        const iconMax = document.getElementById('iconMax');
        const iconMin = document.getElementById('iconMin');
        const navbar  = document.getElementById('mainNavbar');
        const container = document.getElementById('gameContainer'); // Slot Machine
        const dataSection = document.getElementById('dataSection'); // Tabel Data
        const body = document.body;

        if (document.fullscreenElement) {
            // === MASUK MODE FULLSCREEN ===
            
            // 1. Matikan Padding Body biar mepet layar
            body.classList.remove('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');
            
            // 2. Sembunyikan Navbar SAJA (Tabel Tetap Muncul)
            if (navbar) navbar.classList.add('hidden');
            
            // 3. Ganti Icon Toggle
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
            
            // 5. Rapikan Jarak Tabel (Opsional)
            if (dataSection) {
                dataSection.classList.remove('hidden'); // Pastikan tabel TIDAK hilang
                dataSection.classList.add('mt-10'); // Kasih jarak dikit dari slot
            }

        } else {
            // === KELUAR MODE FULLSCREEN ===

            // 1. Balikin Padding Body
            body.classList.add('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');

            // 2. Munculkan Navbar
            if (navbar) navbar.classList.remove('hidden');

            // 3. Balikin Icon Toggle
            if (iconMax && iconMin) { 
                iconMax.classList.remove('hidden'); 
                iconMin.classList.add('hidden'); 
            }

            // 4. Kecilkan Slot Machine ke Semula
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

    // ==========================================
    // 3. LOGIKA SLOT MACHINE (INTEGRASI LIVEWIRE)
    // ==========================================
    
    // Ambil data hadiah yang dikirim dari Controller PHP
    const prizes = @js($jsRewards); 
    
    let intervalId;
    let isSpinning = false;
    let currentWinner = null; // Data pemenang dari Server
    let spinAudioObject = null;

    // Fungsi Ganti Hadiah (Dropdown Change)
    window.changePrize = function() {
        const select = document.getElementById('prizeSelect');
        if(!select || select.options.length === 0) return; 

        const val = select.value;
        // Cek apakah data hadiah ada di array prizes
        if(!prizes[val]) return;

        const data = prizes[val]; 
        
        const imgEl = document.getElementById('prizeImage');
        const nameEl = document.getElementById('prizeNameDisplay');
        const stockBadge = document.getElementById('stockBadge');
        const outOfStockLabel = document.getElementById('outOfStockLabel');
        const msgStockEmpty = document.getElementById('msgStockEmpty');
        const btnStart = document.getElementById('btnStart');

        imgEl.src = data.gambar;
        nameEl.innerText = data.nama_hadiah;
        
        if (data.stok > 0) {
            btnStart.disabled = false;
            btnStart.classList.remove('opacity-50', 'cursor-not-allowed');
            imgEl.style.filter = "none";
            
            if(outOfStockLabel) outOfStockLabel.classList.add('hidden');
            if(msgStockEmpty) msgStockEmpty.classList.add('hidden');

            stockBadge.innerText = "Sisa: " + data.stok;
            stockBadge.className = "bg-green-100 text-green-700 px-3 py-1 rounded-full text-lg font-bold border border-green-200 shadow-sm";
        } else {
            btnStart.disabled = true;
            btnStart.classList.add('opacity-50', 'cursor-not-allowed');
            imgEl.style.filter = "grayscale(100%)";
            
            if(outOfStockLabel) outOfStockLabel.classList.remove('hidden');
            if(msgStockEmpty) msgStockEmpty.classList.remove('hidden');

            stockBadge.innerText = "Stok Habis";
            stockBadge.className = "bg-red-100 text-red-700 px-3 py-1 rounded-full text-lg font-bold border border-red-200 shadow-sm";
        }
    }

    // Fungsi Mulai Spin (Request ke Backend)
    window.startSpin = async function() {
        const val = document.getElementById('prizeSelect').value;
        if (!prizes[val] || prizes[val].stok <= 0) return;
        
        if (isSpinning) return;
        isSpinning = true;

        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');
        const slots = Array.from(document.querySelectorAll('.slot-box'));

        // 1. Reset Tampilan Angka
        slots.forEach(slot => {
            slot.classList.remove('slot-stopped');
            slot.innerText = "0";
            slot.style.transform = "scale(1)";
        });
        
        // 2. Mainkan Audio Spin
        if (spinAudioObject) spinAudioObject.pause();
        spinAudioObject = window.playSoundEffect('spin');

        // 3. Disable Tombol Start
        btnStart.disabled = true;
        btnStart.classList.add('opacity-50', 'cursor-not-allowed');
        
        // 4. Mulai Animasi Angka Acak (Visual Saja)
        intervalId = setInterval(() => {
            slots.forEach(slot => slot.innerText = Math.floor(Math.random() * 10));
        }, 60);

        // 5. Minta Data Pemenang ke Livewire (Server)
        try {
            // Panggil method PHP 'pickWinner'
            // Tunggu sampai server membalas...
            const winnerData = await $wire.pickWinner();

            if (!winnerData) {
                alert("Maaf, tidak ada peserta yang memenuhi syarat atau data kosong!");
                location.reload(); 
                return;
            }

            // Simpan data pemenang
            currentWinner = winnerData;

            // 6. Nyalakan Tombol Stop (Hanya setelah data diterima)
            btnStop.disabled = false;
            btnStop.classList.remove('opacity-50', 'cursor-not-allowed');

        } catch (error) {
            console.error("Gagal mengambil pemenang:", error);
            alert("Terjadi kesalahan koneksi ke server.");
            isSpinning = false;
            btnStart.disabled = false;
            btnStart.classList.remove('opacity-50', 'cursor-not-allowed');
            clearInterval(intervalId);
            if (spinAudioObject) spinAudioObject.pause();
        }
    }

    // Fungsi Stop Spin (Menampilkan Angka Asli)
    window.stopSpinSequence = function() {
        if (!isSpinning) return;
        
        const btnStop = document.getElementById('btnStop');
        btnStop.disabled = true;
        btnStop.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Hentikan acakan cepat
        clearInterval(intervalId);

        // Ambil NIP Pemenang dari Server
        // Pastikan jadi string dan ambil 6 digit (atau sesuaikan kebutuhan)
        const nipString = String(currentWinner.nip || '000000'); 
        // Kita ambil 6 digit pertama. Kalau NIP panjang, sesuaikan logic substring ini.
        // Contoh: nipString.substring(nipString.length - 6) untuk 6 digit terakhir
        const targetNumbers = nipString.substring(0, 6).split(''); 

        const slots = Array.from(document.querySelectorAll('.slot-box'));

        // Loop animasi berhenti satu per satu
        slots.forEach((slot, index) => {
            // Putar acak lokal sebentar
            let localInterval = setInterval(() => {
                slot.innerText = Math.floor(Math.random() * 10);
            }, 60);

            // Berhenti bertahap (Delay index * 1000ms)
            setTimeout(() => {
                clearInterval(localInterval);
                
                // Tampilkan Angka Asli NIP
                // Jika NIP kurang dari 6 digit, tampilkan 0
                slot.innerText = targetNumbers[index] !== undefined ? targetNumbers[index] : 0;
                
                window.playSoundEffect('stop');
                
                // Efek visual
                slot.classList.add('slot-stopped'); 
                slot.style.transform = "scale(1.2)";
                setTimeout(() => slot.style.transform = "scale(1)", 150);

                // Jika ini slot terakhir (Selesai)
                if (index === slots.length - 1) {
                    isSpinning = false;
                    if (spinAudioObject) spinAudioObject.pause(); 
                    
                    // Tampilkan Modal Pemenang
                    setTimeout(() => window.showModal(), 1000);
                }
            }, index * 1000); 
        });
    }

    // ==========================================
    // 4. MODAL & KONFIRMASI
    // ==========================================

    window.showModal = function () {
        window.playSoundEffect('win'); 
        window.fireConfetti();

        const modal = document.getElementById('winnerModal');
        const prizeVal = document.getElementById('prizeSelect').value;
        const dataHadiah = prizes[prizeVal];

        // Isi data modal dari currentWinner (Server)
        document.getElementById('winnerPhoto').src = currentWinner.photo;
        document.getElementById('winnerName').innerText = currentWinner.name;
        document.getElementById('winnerNip').innerText = "NIP: " + currentWinner.nip;
        document.getElementById('winnerAgency').innerText = currentWinner.agency;
        
        document.getElementById('winnerPrize').innerText = dataHadiah.name;
        
        // Info stok sementara (visual)
        const currentStock = dataHadiah.stok;
        document.getElementById('modalStockInfo').innerText = "Sisa stok saat ini: " + currentStock + " (Akan berkurang jika ditetapkan)";

        modal.classList.remove('hidden');
    }

    // Tombol "Tetapkan Pemenang" (Simpan ke DB)
    window.confirmWinner = function () {
        const val = document.getElementById('prizeSelect').value;
        const prizeId = prizes[val].id;
        
        // Panggil Livewire untuk simpan permanen & kurangi stok
        $wire.saveWinner(currentWinner.id, prizeId);
        
        window.closeModal();
    }

    window.cancelWinner = function() {
        window.closeModal();
    }

    window.closeModal = function() {
        const modal = document.getElementById('winnerModal');
        modal.classList.add('hidden');
        window.resetButtons();
    }

    window.resetButtons = function() {
        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');
        const val = document.getElementById('prizeSelect').value;
        
        // Cek stok lagi dari data JS (walaupun belum refresh, minimal visual benar)
        if (prizes[val] && prizes[val].stok > 0) {
            btnStart.disabled = false;
            btnStart.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        btnStop.disabled = true;
        btnStop.classList.add('opacity-50', 'cursor-not-allowed');
    }

    // ==========================================
    // 5. INIT PERTAMA KALI
    // ==========================================
    // Jalankan sekali saat halaman dimuat untuk set gambar awal
    window.changePrize();

</script>
@endscript