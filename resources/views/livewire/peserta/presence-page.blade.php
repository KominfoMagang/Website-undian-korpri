<div>
    {{-- Logo kota tasik, Korpri , dan banner korpri --}}
    <x-peserta.banner />

    <!-- Input form cek NIP START -->
    <div class="flex justify-between items-center mb-4">
        <span class="text-gray-600 text-sm font-semibold">Cek NIP</span>
        <span class="text-sm font-medium">{{ strlen($nip) }}/18</span>

    </div>

    <div class="mb-4">
        <input type="text" inputmode="numeric" pattern="[0-9]{18}" wire:model.live.debounce.250ms="nip" maxlength="18"
            placeholder="Masukkan NIP kamu"
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

            <img src="static/images/pattern.png"
                class="absolute top-0 right-0 w-28 opacity-40 pointer-events-none select-none" />

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
                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-auto object-cover block">
                @else
                    {{-- Tampilan awal upload --}}
                    <div class="min-h-[200px] flex flex-col items-center justify-center">
                        <img src="static/images/imgUpload.svg" class="mb-2" />
                        <p class="text-gray-700 text-sm font-medium">
                            Foto Selfie untuk kehadiran
                        </p>
                    </div>
                @endif
            </label>

            {{-- INPUT FOTO --}}
            <input type="file" id="photoInput" accept="image/*" capture="user" wire:model.live.debounce.250ms="photo"
                class="hidden">

            @error('photo')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>



    @endif

    <!-- Checkbox Agreement -->
    <div class="mb-4">
        <label class="flex items-start gap-2">
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
    <button wire:click="klaimKupon" @if (!$showDetails) disabled @endif
        class="w-full bg-[#5065A4] text-white font-semibold py-3 rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
        Klaim Kupon
    </button>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>
