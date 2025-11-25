<div x-data="locationHandler()" x-init="init()">

    {{-- ================== CEK LOKASI DALAM RADIUS ================== --}}
    @if (!$locationGranted)
        <!-- ================= OVERLAY LOADING (Meminta Akses Lokasi) ================= -->
        <div x-show="showLoading" x-transition class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

            <div class="bg-white p-6 rounded-2xl shadow-lg text-center max-w-xs w-full mx-4">

                <!-- Spinner -->
                <div class="flex justify-center mb-4">
                    <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                        </path>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                    Meminta Akses Lokasi
                </h3>

                <p class="text-gray-600 text-sm">
                    Mohon izinkan akses lokasi untuk melanjutkan.
                </p>

                @if ($locationErrorMessage)
                    <p class="text-red-600 text-sm mt-3 font-semibold whitespace-pre-line">
                        {{ $locationErrorMessage }}
                    </p>
                @endif
            </div>

        </div>


        <!-- ================= OVERLAY LOKASI DITOLAK ATAU DI LUAR RADIUS ================= -->
        <div x-show="showDenied" x-transition class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

            <div class="bg-white p-6 rounded-2xl shadow-lg text-center max-w-xs w-full mx-4">

                <!-- Illustration -->
                <img src="{{ asset('static/images/deniedLocation.png') }}" alt="Location Denied"
                    class="w-40 mx-auto mb-4"
                    onerror="this.onerror=null; this.src='{{ asset('images/deniedLocation.png') }}';">

                <!-- Title -->
                <h3 class="text-lg font-bold text-gray-800 leading-relaxed mb-1">
                    hmmm... Kamu tidak di lokasi<br>Balekota Tasikmalaya
                </h3>

                <!-- Subtitle -->
                <p class="text-gray-600 text-sm mb-6">
                    Absensi kehadiran harus di dalam lingkungan balekota Tasikmalaya
                </p>

                <!-- Button -->
                <button @click="requestLocation()"
                    class="bg-[#5065A4] text-white px-5 py-2.5 rounded-xl w-full font-semibold hover:opacity-90 transition">
                    Cek Lokasi Lagi
                </button>
            </div>

        </div>


        <!-- ================= SCRIPT ALPINE.JS ================= -->
        <script>
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    console.log("Latitude :", pos.coords.latitude);
                    console.log("Longitude:", pos.coords.longitude);
                },
                function(err) {
                    console.log("Error:", err.message);
                }
            );

            function locationHandler() {
                return {
                    showLoading: true,
                    showDenied: false,

                    init() {
                        // Listen untuk event dari Livewire
                        window.addEventListener('location-denied', () => {
                            this.showLoading = false;
                            this.showDenied = true;
                        });

                        // Otomatis request lokasi saat load
                        this.requestLocation();
                    },

                    requestLocation() {
                        this.showDenied = false;
                        this.showLoading = true;

                        if ("geolocation" in navigator) {
                            navigator.geolocation.getCurrentPosition(
                                (pos) => {
                                    // Kirim ke Livewire untuk validasi
                                    @this.call('checkLocation', pos.coords.latitude, pos.coords.longitude);
                                },
                                (error) => {
                                    // User menolak atau error
                                    console.error('Geolocation error:', error);
                                    this.showLoading = false;
                                    this.showDenied = true;

                                    @this.call('locationFailed', error.code);
                                }, {
                                    enableHighAccuracy: true,
                                    timeout: 10000,
                                    maximumAge: 0
                                }
                            );
                        } else {
                            alert("Browser tidak mendukung GPS");
                            this.showLoading = false;
                            this.showDenied = true;
                        }
                    }
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
                class="w-full border-2 border-gray-300 rounded-lg p-3 text-sm font-semibold focus:border-blue-500 focus:outline-none transition-colors @error('nip') border-red-500 @enderror">

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
                <input type="checkbox" class="mt-1" wire:model="agreement">
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
