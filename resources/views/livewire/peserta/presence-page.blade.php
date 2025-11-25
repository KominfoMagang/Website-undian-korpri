<div x-data="locationHandler()" x-init="init()">

    {{-- ================== CEK LOKASI DALAM RADIUS ================== --}}
    @if (!$locationGranted)
        <!-- ================= OVERLAY LOADING (Meminta Akses Lokasi) ================= -->
        <div x-show="showLoading" x-transition
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-xs w-full mx-4">
                <div class="flex justify-center mb-5">
                    <div class="relative">
                        <div class="w-12 h-12 border-4 border-blue-200 rounded-full"></div>
                        <div
                            class="w-12 h-12 border-4 border-blue-600 rounded-full animate-spin absolute top-0 left-0 border-t-transparent">
                        </div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Melacak Lokasi...</h3>
                <p class="text-gray-500 text-sm">Mohon izinkan akses lokasi.</p>
            </div>
        </div>

        {{-- ================== 2. OVERLAY LOKASI DITOLAK / ERROR / DI LUAR RADIUS ================== --}}
        <div x-show="showDenied" x-cloak x-transition
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-2xl shadow-xl text-center max-w-sm w-full mx-4 relative overflow-hidden">

                <img src="{{ asset('static/images/deniedLocation.png') }}" alt="Location Denied"
                    class="w-32 mx-auto mb-4 drop-shadow-md"
                    onerror="this.onerror=null; this.src='{{ asset('static/images/deniedLocation.png') }}';">

                <h3 class="text-xl font-bold text-gray-800 leading-tight mb-2">
                    <span x-text="isPermDenied ? 'Akses Ditolak' : 'Lokasi Tidak Sesuai'"></span>
                </h3>
                <p class="text-gray-600 text-sm mb-4 px-2 leading-relaxed" x-text="deniedMessage"></p>

                {{-- ============================================================ --}}
                {{-- PANDUAN KHUSUS (Hanya muncul jika Browser BLOCK akses) --}}
                {{-- ============================================================ --}}
                <div x-show="isPermDenied"
                    class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-5 text-left animate-fade-in-down">
                    <p class="text-xs font-bold text-blue-800 mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Cara Mengaktifkan Izin:
                    </p>
                    <ol class="list-decimal ml-4 text-[11px] text-blue-700 space-y-1.5 font-medium">
                        <li>Klik ikon <strong>Gembok (🔒)</strong> / Pengaturan di bar alamat browser.</li>
                        <li>Klik menu <strong>Izin / Permissions</strong>.</li>
                        <li>Aktifkan saklar <strong>Lokasi / Location</strong>.</li>
                        <li>Lalu klik tombol <strong>Refresh Halaman</strong> di bawah.</li>
                    </ol>
                </div>

                {{-- TOMBOL AKSI --}}
                <button @click="retryLocation()"
                    class="w-full text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform active:scale-95 transition flex items-center justify-center gap-2"
                    :class="isPermDenied ? 'bg-blue-600 hover:bg-blue-700' : 'bg-[#5065A4] hover:opacity-90'">

                    {{-- Ikon Refresh (Muncul jika Blocked) --}}
                    <svg x-show="isPermDenied" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>

                    {{-- Ikon Pin (Muncul jika Di Luar Radius/GPS Error) --}}
                    <svg x-show="!isPermDenied" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    {{-- Teks Tombol Berubah Sesuai Kondisi --}}
                    <span x-text="isPermDenied ? 'Refresh Halaman' : 'Cek Lokasi Lagi'"></span>
                </button>
            </div>
        </div>

        {{-- ================= SCRIPT ALPINE.JS ================= --}}
        <script>
            function locationHandler() {
                return {
                    showLoading: true,
                    showDenied: false,
                    isPermDenied: false, 
                    deniedMessage: '',

                    init() {
                        window.addEventListener('location-radius-error', () => {
                            this.showLoading = false;
                            this.showDenied = true;
                            this.isPermDenied = false;
                            this.deniedMessage =
                                'Kamu berada di luar radius lokasi acara. Silakan merapat ke titik lokasi.';
                        });

                        window.addEventListener('permission-blocked', () => {
                            this.handlePermissionDenied();
                        });

                        window.addEventListener('location-system-error', () => {
                            this.showLoading = false;
                            this.showDenied = true;
                            this.isPermDenied = false;
                            this.deniedMessage = 'Gagal mendapatkan posisi. Pastikan GPS aktif dan sinyal bagus.';
                        });

                        // Cek permission awal saat load
                        if (navigator.permissions && navigator.permissions.query) {
                            navigator.permissions.query({
                                name: 'geolocation'
                            }).then((result) => {
                                if (result.state === 'denied') {
                                    this.handlePermissionDenied();
                                } else {
                                    this.requestLocation();
                                }
                            });
                        } else {
                            this.requestLocation();
                        }
                    },

                    retryLocation() {
                        if (this.isPermDenied) {
                            window.location.reload();
                        } else {
                            this.requestLocation();
                        }
                    },

                    requestLocation() {
                        this.showDenied = false;
                        this.showLoading = true;
                        this.isPermDenied = false;

                        if ("geolocation" in navigator) {
                            navigator.geolocation.getCurrentPosition(
                                (pos) => {
                                    @this.call('checkLocation', pos.coords.latitude, pos.coords.longitude);
                                },
                                (error) => {
                                    // GAGAL -> Tangani di JS dulu
                                    console.error('Geolocation error:', error);

                                    if (error.code === 1) {
                                        this.handlePermissionDenied();
                                        @this.call('locationFailed', 1);
                                    } else {
                                        // Error lain kirim ke PHP biar PHP yang dispatch 'location-system-error'
                                        @this.call('locationFailed', error.code);
                                    }
                                }, {
                                    enableHighAccuracy: true,
                                    timeout: 10000,
                                    maximumAge: 0
                                }
                            );
                        } else {
                            this.showLoading = false;
                            this.showDenied = true;
                            this.deniedMessage = "Browser tidak mendukung GPS";
                        }
                    },

                    handlePermissionDenied() {
                        // Logika UI untuk Blocked
                        this.showLoading = false;
                        this.showDenied = true;
                        this.isPermDenied = true;
                        this.deniedMessage = "Akses lokasi diblokir browser. Anda perlu mengizinkannya secara manual.";
                    },
                }
            }
        </script>
    @else
        {{-- ================== FORM MUNCUL KALAU DALAM RADIUS ================== --}}

        <x-peserta.banner />

        <!-- Input form cek NIP START -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-gray-600 text-sm font-semibold">Cek NIP</span>
            <span class="text-sm font-medium">{{ strlen($nip) }}/18</span>
        </div>

        <div class="mb-4">
            <input type="text" inputmode="numeric" pattern="[0-9]{18}" wire:model.live.debounce.250ms="nip"
                maxlength="18" placeholder="Masukkan NIP kamu"
                class="w-full border-2 border-gray-300 rounded-lg p-3 text-sm font-semibold focus:border-blue-500 focus:outline-none transition-colors @error('nip') @enderror">

            <!-- Error Message -->
            @if ($errorMessage)
                <p class="text-red-500 text-sm mt-2 text-center">{{ $errorMessage }}</p>
            @endif
        </div>

        <!-- Input form cek NIP END -->

        <!-- NIP Verification Status -->
        @if (strlen($nip) === 18 && !$showDetails && !$errorMessage)
            <div class="mb-4">
                <p class="text-blue-600 font-semibold text-center animate-pulse">
                    Memverifikasi NIP...
                </p>
            </div>
        @endif

        @if ($showDetails)
            <div class="mb-4">
                <p class="text-green-600 font-semibold text-center">
                    NIP kamu Terverifikasi sebagai peserta doorprize
                </p>
            </div>
        @endif

        <!-- Detail Data Section ketika NIP valid-->
        @if ($showDetails)
            <div class="relative bg-blue-50 rounded-lg p-4 mb-4 overflow-hidden">

                <img src="{{ asset('static/images/pattern.png') }}"
                    class="absolute top-0 right-0 w-28 opacity-40 pointer-events-none select-none" alt="Pattern" />

                <h3 class="font-bold text-gray-800 mb-3 relative">Detail Data</h3>

                <div class="space-y-2 relative">
                    <div class="flex justify-start gap-2">
                        <span class="text-gray-600 text-sm">Nama:</span>
                        <span class="text-gray-800 text-sm font-medium">{{ $detailData['nama'] }}</span>
                    </div>
                    <div class="flex justify-start gap-2">
                        <span class="text-gray-600 text-sm">NIP:</span>
                        <span class="text-gray-800 text-sm font-medium">{{ $detailData['nip'] }}</span>
                    </div>
                    <div class="flex justify-start gap-2">
                        <span class="text-gray-600 text-sm">Unit Kerja:</span>
                        <span class="text-gray-800 text-sm font-medium">{{ $detailData['unit_kerja'] }}</span>
                    </div>
                </div>
            </div>

            {{-- UPLOAD SELFIE KAMERA --}}
            <div class="mb-4">
                <label for="photoInput"
                    class="cursor-pointer bg-blue-50 border-2 border-dashed border-blue-300 rounded-xl block text-center hover:bg-blue-100 transition overflow-hidden">

                    @if ($photo)
                        {{-- Preview foto --}}
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-auto object-cover block" alt="Preview">
                    @else
                        {{-- Tampilan awal upload --}}
                        <div class="min-h-[200px] flex flex-col items-center justify-center">
                            <img src="{{ asset('static/images/imgUpload.svg') }}" class="mb-2" alt="Upload" />
                            <p class="text-gray-700 text-sm font-medium">
                                Foto Selfie untuk kehadiran
                            </p>
                        </div>
                    @endif
                </label>

                {{-- INPUT FOTO --}}
                <input type="file" id="photoInput" accept="image/*" capture="user"
                    wire:model.live.debounce.250ms="photo" class="hidden">

                @error('photo')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <!-- Checkbox Agreement -->
        <div class="mb-4">
            <label class="flex items-start gap-2 cursor-pointer">
                <input type="checkbox" class="mt-1" wire:model.live="agreement">
                <div class="flex flex-col text-gray-600 text-xs leading-relaxed">
                    <span class="font-semibold">Saya yakin data tersebut sudah benar.</span>
                    <span>
                        Setelah klaim Kupon Anda akan mendapat nomor undian kupon.
                    </span>
                </div>
            </label>
        </div>

        <!-- Button -->
        <button wire:click="klaimKupon" wire:loading.attr="disabled" @if (!$showDetails || !$agreement) disabled @endif
            class="w-full bg-[#5065A4] text-white font-semibold py-3 rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="klaimKupon">Klaim Kupon</span>
            <span wire:loading wire:target="klaimKupon">Memproses...</span>
        </button>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

    @endif
</div>
