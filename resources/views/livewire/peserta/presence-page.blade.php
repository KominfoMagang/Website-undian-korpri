<div x-data="presencePage()" x-init="initLocation()">

    {{-- ================== 1. NOTIFIKASI ERROR SYSTEM / RATE LIMIT ================== --}}
    @error('system')
        <div class="fixed top-4 left-0 right-0 z-60 px-4 animate-bounce">
            <div class="bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl max-w-lg mx-auto flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h4 class="font-bold text-lg">Gagal Memproses</h4>
                    <p class="text-sm font-medium">{{ $message }}</p>
                </div>
                <button type="button" class="ml-auto bg-white/20 p-1 rounded-full hover:bg-white/30"
                    onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @enderror

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

        {{-- ================== OVERLAY LOKASI DITOLAK / ERROR ================== --}}
        <div x-show="showDenied" x-cloak x-transition
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-2xl shadow-xl text-center max-w-sm w-full mx-4 relative overflow-hidden">

                <img src="{{ asset('static/images/deniedLocation.png') }}" alt="Location Denied"
                    class="w-32 mx-auto mb-4 drop-shadow-md"
                    onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=Location+Error';">

                <h3 class="text-xl font-bold text-gray-800 leading-tight mb-2">
                    <span x-text="isPermDenied ? 'Akses Ditolak' : 'Lokasi Tidak Sesuai'"></span>
                </h3>
                <p class="text-gray-600 text-sm mb-4 px-2 leading-relaxed" x-text="deniedMessage"></p>

                {{-- PANDUAN KHUSUS (Blocked) --}}
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
                        <li>Klik ikon <strong>Gembok (🔒)</strong> di bar alamat.</li>
                        <li>Klik menu <strong>Izin / Permissions</strong>.</li>
                        <li>Aktifkan <strong>Lokasi / Location</strong>.</li>
                        <li>Klik tombol <strong>Refresh Halaman</strong>.</li>
                    </ol>
                </div>

                {{-- TOMBOL AKSI --}}
                <button @click="retryLocation()"
                    class="w-full text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform active:scale-95 transition flex items-center justify-center gap-2"
                    :class="isPermDenied ? 'bg-blue-600 hover:bg-blue-700' : 'bg-[#5065A4] hover:opacity-90'">
                    <span x-text="isPermDenied ? 'Refresh Halaman' : 'Cek Lokasi Lagi'"></span>
                </button>
            </div>
        </div>
    @else
        {{-- ================== FORM MUNCUL KALAU DALAM RADIUS ================== --}}

        <x-peserta.banner />

        <!--==================BAGIAN FORM INPUT NIP==================-->
            {{-- Header Input --}}
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-600 text-sm font-semibold">Cek NIP</span>
                <span class="text-sm font-medium {{ strlen($nip) === 18 ? 'text-green-600' : 'text-gray-500' }}">
                    {{ strlen($nip) }}/18
                </span>
            </div>

            {{-- Input Field --}}
            <div class="mb-4">
                <input type="text" inputmode="numeric" pattern="[0-9]*" wire:model.live.debounce.250ms="nip"
                    maxlength="18" placeholder="Masukkan NIP kamu"
                    class="w-full border-2 border-gray-300 rounded-lg p-3 text-sm font-semibold focus:border-blue-500 focus:outline-none transition-colors @error('nip') @enderror">

                @if ($errorMessage)
                    <p class="text-red-500 text-sm mt-2 text-center font-bold bg-red-50 p-2 rounded">
                        {{ $errorMessage }}
                    </p>
                @endif
            </div>

            <!-- ================== LOADING STATE ================== -->
            <div wire:loading wire:target="nip" class="w-full mb-4">
                <div
                    class="text-blue-600 font-semibold text-center animate-pulse flex justify-center items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memverifikasi NIP...
                </div>
            </div>

            <!-- ================== HASIL VERIFIKASI (DETAIL & UPLOAD) ================== -->
            <div wire:loading.remove wire:target="nip">
                @if ($showDetails)
                    <div class="animate-fade-in-up">

                        {{-- 1. Pesan Sukses --}}
                        <div class="mb-4">
                            <p
                                class="text-green-600 font-semibold text-center bg-green-50 p-2 rounded border border-green-200 text-sm flex items-center justify-center gap-2">
                                NIP kamu Terverifikasi Sebagai Peserta Doorprize
                            </p>
                        </div>

                        {{-- 2. Detail Data Section --}}
                        <div class="relative bg-blue-50 rounded-lg p-4 mb-4 overflow-hidden border border-blue-100">
                            <img src="{{ asset('static/images/pattern.png') }}"
                                class="absolute top-0 right-0 w-28 opacity-40 pointer-events-none select-none"
                                alt="Pattern" onerror="this.style.display='none'" />

                            <h3 class="font-bold text-gray-800 mb-3 relative z-10">Detail Data</h3>

                            <div class="space-y-2 relative z-10">
                                <div class="flex justify-start gap-2">
                                    <span class="text-gray-600 text-sm min-w-[70px]">Nama:</span>
                                    <span class="text-gray-800 text-sm font-bold">{{ $detailData['nama'] }}</span>
                                </div>
                                <div class="flex justify-start gap-2">
                                    <span class="text-gray-600 text-sm min-w-[70px]">NIP:</span>
                                    <span
                                        class="text-gray-800 text-sm font-medium font-mono bg-white/50 px-1 rounded">{{ $detailData['nip'] }}</span>
                                </div>
                                <div class="flex justify-start gap-2">
                                    <span class="text-gray-600 text-sm min-w-[70px]">Unit Kerja:</span>
                                    <span
                                        class="text-gray-800 text-sm font-medium">{{ $detailData['unit_kerja'] }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Upload Selfie Section --}}
                        <div class="mb-4">
                            <label for="photoInput"
                                class="relative cursor-pointer bg-white border-2 border-dashed border-blue-300 rounded-xl block text-center hover:bg-blue-50 transition overflow-hidden group">

                                {{-- Loading Overlay saat Upload --}}
                                <div x-show="isUploading" style="display: none;"
                                    class="absolute inset-0 bg-white/90 z-20 flex flex-col items-center justify-center backdrop-blur-sm">
                                    <div
                                        class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-2">
                                    </div>
                                    <span class="text-xs font-bold text-blue-600">
                                        Upload <span x-text="progress + '%'"></span>
                                    </span>
                                </div>

                                @if ($photo)
                                    {{-- Preview foto --}}
                                    <div class="relative">
                                        <img src="{{ $photo->temporaryUrl() }}"
                                            class="w-full object-cover block rounded-lg" alt="Preview">
                                        <div
                                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span
                                                class="text-white text-sm font-bold bg-black/50 px-3 py-1 rounded-full">Ganti
                                                Foto</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="min-h-[150px] flex flex-col items-center justify-center p-6">
                                        <img src="{{ asset('static/images/imgUpload.svg') }}"
                                            class="mb-3 w-16 h-16 opacity-80" alt="Upload" />
                                        <p class="text-gray-800 text-sm font-bold">Ambil Foto Selfie Untuk Kehadiran
                                        </p>
                                        <p class="text-gray-500 text-xs mt-1">Ketuk di sini untuk membuka kamera</p>
                                    </div>
                                @endif
                            </label>

                            {{-- Input File Hidden --}}
                            <input type="file" id="photoInput" accept="image/*" capture="user"
                                @change="compressAndUpload($event)" class="hidden">

                            @error('photo')
                                <p class="text-red-500 text-sm mt-2 text-center font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                @endif
            </div>

            <!-- Checkbox Agreement -->
            <div class="mb-4">
                <label class="flex items-start gap-2 cursor-pointer p-2 rounded hover:bg-gray-50">
                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                        wire:model.live="agreement">
                    <div class="flex flex-col text-gray-600 text-xs leading-relaxed">
                        <span class="font-semibold text-gray-800">Saya menyatakan data di atas benar.</span>
                        <span>
                            Data ini akan digunakan untuk undian doorprize.
                        </span>
                    </div>
                </label>
                @error('agreement')
                    <span class="text-red-500 text-xs ml-6">{{ $message }}</span>
                @enderror
            </div>

            <!-- Button -->
            <button wire:click="klaimKupon" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                @if (!$showDetails || !$agreement || !$photo) disabled @endif
                class="w-full bg-[#5065A4] text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center gap-2">

                <span wire:loading.remove wire:target="klaimKupon">Klaim Kupon</span>

                <span wire:loading wire:target="klaimKupon" class="flex items-center gap-1">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>

            <!-- Success Message -->
            @if (session()->has('success'))
                <div
                    class="mt-6 bg-green-50 border border-green-200 text-green-800 px-4 py-4 rounded-xl text-center shadow-sm animate-bounce">
                    <h4 class="font-bold text-lg mb-1">🎉 Berhasil!</h4>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

    @endif

    {{-- ================= SCRIPT ALPINE.JS (FIXED) ================= --}}
    <script>
        function presencePage() {
            return {
                // State Lokasi
                showLoading: true,
                showDenied: false,
                isPermDenied: false,
                deniedMessage: '',

                // State Upload
                isUploading: false,
                progress: 0,

                initLocation() {
                    window.addEventListener('location-radius-error', () => {
                        this.showDeniedState('Kamu berada di luar radius lokasi acara.');
                    });
                    window.addEventListener('permission-blocked', () => {
                        this.handlePermissionDenied();
                    });
                    window.addEventListener('location-system-error', () => {
                        this.showDeniedState('Gagal mendapatkan posisi. Pastikan GPS aktif.');
                    });

                    // Cek Permission
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

                // --- HELPER LOKASI ---
                showDeniedState(msg) {
                    this.showLoading = false;
                    this.showDenied = true;
                    this.isPermDenied = false;
                    this.deniedMessage = msg;
                },

                retryLocation() {
                    if (this.isPermDenied) window.location.reload();
                    else this.requestLocation();
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
                                console.error('Geolocation error:', error);
                                if (error.code === 1) {
                                    this.handlePermissionDenied();
                                    @this.call('locationFailed', 1);
                                } else {
                                    @this.call('locationFailed', error.code);
                                }
                            }, {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
                        );
                    } else {
                        this.showDeniedState("Browser tidak mendukung GPS");
                    }
                },

                handlePermissionDenied() {
                    this.showLoading = false;
                    this.showDenied = true;
                    this.isPermDenied = true;
                    this.deniedMessage = "Akses lokasi diblokir browser. Anda perlu mengizinkannya secara manual.";
                },

                // --- LOGIKA KOMPRESI GAMBAR (PERBAIKAN UTAMA DISINI) ---
                compressAndUpload(event) {
                    const originalFile = event.target.files[0];
                    if (!originalFile) return;

                    // Validasi tipe file
                    if (!originalFile.type.match(/image.*/)) {
                        alert('Mohon upload file gambar.');
                        return;
                    }

                    // Set status uploading
                    this.isUploading = true;
                    this.progress = 0;

                    const reader = new FileReader();
                    reader.readAsDataURL(originalFile);

                    reader.onload = (readerEvent) => {
                        const image = new Image();
                        image.onload = () => {
                            // Setup Canvas
                            const canvas = document.createElement('canvas');
                            const max_size = 800; // Resize ke max 800px
                            let width = image.width;
                            let height = image.height;

                            // Logika Aspect Ratio
                            if (width > height) {
                                if (width > max_size) {
                                    height *= max_size / width;
                                    width = max_size;
                                }
                            } else {
                                if (height > max_size) {
                                    width *= max_size / height;
                                    height = max_size;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;

                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(image, 0, 0, width, height);

                            // Convert Canvas ke Blob (JPG Quality 0.6)
                            canvas.toBlob((blob) => {
                                // === PERBAIKAN: Ubah Blob menjadi File Object dengan nama .jpg ===
                                // Ini mencegah error "extension empty" di Livewire
                                const fileName = "selfie_compressed.jpg";
                                const fileToUpload = new File([blob], fileName, {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });

                                // Upload manual ke Livewire
                                @this.upload('photo', fileToUpload,
                                    (uploadedFilename) => {
                                        // Success
                                        this.isUploading = false;
                                        this.progress = 100;
                                    },
                                    () => {
                                        // Error
                                        this.isUploading = false;
                                        alert('Gagal mengupload gambar. Coba lagi.');
                                    },
                                    (event) => {
                                        // Progress
                                        this.progress = event.detail.progress;
                                    }
                                );
                            }, 'image/jpeg', 0.6);
                        }
                        image.src = readerEvent.target.result;
                    }
                }
            }
        }
    </script>
</div>
