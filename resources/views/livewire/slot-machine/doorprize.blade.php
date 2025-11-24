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
                <option value="sepeda">Sepeda Gunung Polygon</option>
                <option value="kulkas">Kulkas 2 Pintu Sharp</option>
                <option value="tv">Smart TV Samsung 43"</option>
                <option value="motor">Sepeda Motor Listrik</option>
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
                        class="text-white font-black text-xl md:text-2xl uppercase tracking-wider flex items-center gap-2">⚙️
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
    // --- 0. FULLSCREEN LOGIC ---
    window.toggleFullScreen = function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
        }
    }

    document.addEventListener('fullscreenchange', (event) => {
        // 1. Definisi Elemen
        const iconMax = document.getElementById('iconMax');
        const iconMin = document.getElementById('iconMin');
        const navbar  = document.getElementById('mainNavbar');
        const container = document.getElementById('gameContainer');
        const body = document.body;

        if (document.fullscreenElement) {
            // === MASUK MODE FULLSCREEN ===
            
            // A. Matikan Padding & Centering di Body (PENTING!)
            // Ini yang bikin "pagar" putih di pinggir hilang
            body.classList.remove('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');
            
            // B. Sembunyikan Navbar
            if (navbar) navbar.classList.add('hidden');
            
            // C. Ubah Icon Toggle
            if (iconMax && iconMin) { 
                iconMax.classList.add('hidden'); 
                iconMin.classList.remove('hidden'); 
            }

            // D. Transformasi Container Slot jadi Full Layar
            if (container) {
                // Hapus style kotak/kartu (border, rounded, shadow, max-width)
                container.classList.remove('max-w-6xl', 'rounded-3xl', 'border-4', 'shadow-2xl', 'min-h-[600px]');
                
                // Tambahkan style layar penuh
                container.classList.add('w-screen', 'h-screen', 'rounded-none', 'border-0');
                
                // Paksa ukuran style manual (Override CSS lain)
                container.style.width = "100vw";
                container.style.height = "100vh";
                container.style.maxWidth = "100%";
                container.style.margin = "0";
            }

        } else {
            // === KELUAR MODE FULLSCREEN ===

            // A. Kembalikan Padding Body
            body.classList.add('p-4', 'pt-24', 'flex', 'items-center', 'justify-center');

            // B. Munculkan Navbar
            if (navbar) navbar.classList.remove('hidden');

            // C. Balikin Icon
            if (iconMax && iconMin) { 
                iconMax.classList.remove('hidden'); 
                iconMin.classList.add('hidden'); 
            }

            // D. Kembalikan Container ke Bentuk Kotak Asli
            if (container) {
                // Balikin class asli
                container.classList.add('max-w-6xl', 'rounded-3xl', 'border-4', 'shadow-2xl', 'min-h-[600px]');
                
                // Hapus class full layar
                container.classList.remove('w-screen', 'h-screen', 'rounded-none', 'border-0');
                
                // Hapus style manual
                container.style.width = "";
                container.style.height = "";
                container.style.maxWidth = "";
                container.style.margin = "";
            }
        }
    });

    // --- 1. CONFIG CONFETTI ---
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

    // --- 2. AUDIO LOGIC ---
    window.playSoundEffect = function(type) {
        // Ambil element audio (pastikan input hidden ada di HTML)
        const spinEl = document.getElementById('src-spin');
        const stopEl = document.getElementById('src-stop');
        const winEl  = document.getElementById('src-win');

        // Safety check jika element audio tidak ketemu
        if (!spinEl || !stopEl || !winEl) return null;

        const spinSrc = spinEl.value;
        const stopSrc = stopEl.value;
        const winSrc  = winEl.value;

        let audio;
        if (type === 'spin') {
            audio = new Audio(spinSrc);
            audio.loop = true;
            audio.volume = 0.6;
        } else if (type === 'stop') {
            audio = new Audio(stopSrc);
            audio.volume = 1.0;
        } else if (type === 'win') {
            audio = new Audio(winSrc);
            audio.volume = 1.0;
        }
        
        if(audio) {
            audio.play().catch(e => console.log("Audio play prevented:", e));
        }
        return audio;
    }

    // --- 3. DATA & VARIABLES ---
    const prizes = {
        'sepeda': { img: 'https://placehold.co/300x300/png?text=Sepeda+Gunung', name: 'Sepeda Gunung Polygon', stock: 2 },
        'kulkas': { img: 'https://placehold.co/300x300/png?text=Kulkas+2+Pintu', name: 'Kulkas 2 Pintu Sharp', stock: 1 },
        'tv': { img: 'https://placehold.co/300x300/png?text=Smart+TV+43"', name: 'Smart TV Samsung 43"', stock: 5 },
        'motor': { img: 'https://placehold.co/300x300/png?text=Motor+Listrik', name: 'Sepeda Motor Listrik', stock: 0 }
    };

    const mockWinners = [
        { nip: '19850320', name: 'Budi Santoso, S.Kom', agency: 'BAPPEDA', photo: 'https://i.pravatar.cc/150?u=1' },
        { nip: '19901215', name: 'Siti Aminah, M.Si', agency: 'Dinas Kesehatan', photo: 'https://i.pravatar.cc/150?u=2' },
        { nip: '19880101', name: 'Rahmat Hidayat, ST', agency: 'Dinas PU', photo: 'https://i.pravatar.cc/150?u=3' }
    ];

    let intervalId;
    let isSpinning = false;
    let currentWinner = null;
    let spinAudioObject = null;

    // --- 4. CORE FUNCTIONS ---

    window.changePrize = function() {
        const select = document.getElementById('prizeSelect');
        if(!select) return; // Safety check

        const val = select.value;
        const data = prizes[val];
        
        const imgEl = document.getElementById('prizeImage');
        const nameEl = document.getElementById('prizeNameDisplay');
        const stockBadge = document.getElementById('stockBadge');
        const outOfStockLabel = document.getElementById('outOfStockLabel');
        const msgStockEmpty = document.getElementById('msgStockEmpty');
        const btnStart = document.getElementById('btnStart');

        imgEl.src = data.img;
        nameEl.innerText = data.name;

        if (data.stock > 0) {
            btnStart.disabled = false;
            imgEl.style.filter = "none"; // Reset filter grayscale
            if(outOfStockLabel) outOfStockLabel.classList.add('hidden');
            if(msgStockEmpty) msgStockEmpty.classList.add('hidden');
            
            stockBadge.innerText = "Sisa: " + data.stock;
            stockBadge.className = "bg-green-100 text-green-700 px-3 py-1 rounded-full text-lg font-bold border border-green-200 shadow-sm";
            btnStart.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btnStart.disabled = true;
            imgEl.style.filter = "grayscale(100%)";
            if(outOfStockLabel) outOfStockLabel.classList.remove('hidden');
            if(msgStockEmpty) msgStockEmpty.classList.remove('hidden');
            
            stockBadge.innerText = "Stok Habis";
            stockBadge.className = "bg-red-100 text-red-700 px-3 py-1 rounded-full text-lg font-bold border border-red-200 shadow-sm";
            btnStart.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    window.startSpin = function() {
        const val = document.getElementById('prizeSelect').value;
        if (prizes[val].stock <= 0) return;

        if (isSpinning) return;
        isSpinning = true;

        const slots = Array.from(document.querySelectorAll('.slot-box'));
        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');

        slots.forEach(slot => {
            slot.classList.remove('slot-stopped');
            slot.style.transform = "scale(1)";
            slot.innerText = "0";
        });

        if (spinAudioObject) { spinAudioObject.pause(); }
        spinAudioObject = window.playSoundEffect('spin'); // Pakai window.

        btnStart.disabled = true;
        btnStop.disabled = false;
        btnStart.classList.add('opacity-50', 'cursor-not-allowed');
        btnStop.classList.remove('opacity-50', 'cursor-not-allowed');

        currentWinner = mockWinners[Math.floor(Math.random() * mockWinners.length)];
        
        intervalId = setInterval(() => {
            slots.forEach(slot => slot.innerText = Math.floor(Math.random() * 10));
        }, 60);
    }

    window.stopSpinSequence = function() {
        if (!isSpinning) return;
        
        const btnStop = document.getElementById('btnStop');
        const slots = Array.from(document.querySelectorAll('.slot-box'));

        btnStop.disabled = true;
        btnStop.classList.add('opacity-50', 'cursor-not-allowed');
        
        clearInterval(intervalId);

        const targetNumbers = currentWinner.nip.substring(0, 6).split(''); 

        slots.forEach((slot, index) => {
            let localInterval = setInterval(() => {
                slot.innerText = Math.floor(Math.random() * 10);
            }, 60);

            setTimeout(() => {
                clearInterval(localInterval);
                slot.innerText = targetNumbers[index];
                
                window.playSoundEffect('stop'); // Pakai window.
                
                slot.classList.add('slot-stopped'); 
                slot.style.transform = "scale(1.2)";
                setTimeout(() => slot.style.transform = "scale(1)", 150);

                if (index === slots.length - 1) {
                    isSpinning = false;
                    if (spinAudioObject) spinAudioObject.pause(); 
                    setTimeout(() => window.showModal(), 1000); // Pakai window.
                }
            }, index * 1000); 
        });
    }

    window.showModal = function () {
        window.playSoundEffect('win'); // Pakai window.
        window.fireConfetti(); // Pakai window.

        const modal = document.getElementById('winnerModal');
        
        document.getElementById('winnerPhoto').src = currentWinner.photo;
        document.getElementById('winnerName').innerText = currentWinner.name;
        document.getElementById('winnerNip').innerText = "NIP: " + currentWinner.nip;
        document.getElementById('winnerAgency').innerText = currentWinner.agency;
        
        const prizeVal = document.getElementById('prizeSelect').value;
        document.getElementById('winnerPrize').innerText = prizes[prizeVal].name;
        
        const currentStock = prizes[prizeVal].stock;
        document.getElementById('modalStockInfo').innerText = "Sisa stok saat ini: " + currentStock + " (Akan berkurang jika ditetapkan)";

        modal.classList.remove('hidden');
    }

    window.confirmWinner = function () {
        const val = document.getElementById('prizeSelect').value;
        if (prizes[val].stock > 0) {
            prizes[val].stock--; 
            window.changePrize(); 
        }
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
        
        if (prizes[val].stock > 0) {
            btnStart.disabled = false;
            btnStart.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        btnStop.disabled = true;
        btnStop.classList.add('opacity-50', 'cursor-not-allowed');
    }

    // Init Logic
    window.changePrize();
</script>
@endscript