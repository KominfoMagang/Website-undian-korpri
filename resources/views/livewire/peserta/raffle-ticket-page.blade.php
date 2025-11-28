<div>
    <div class="w-full max-w-[420px]">
        <div class="bg-[#DDE2FF] rounded-3xl  mb-6 relative mt-12">
            <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                <img src="{{ $detailData['fotoSelfie'] }}" alt="Selfie {{ $detailData['nama'] ?? 'Peserta' }}"
                    class="w-32 h-32 rounded-full object-cover border-4 border-[#DDE2FF] bg-white shadow-md">
            </div>


            <div class="p-4 pt-20 space-y-3">

                {{-- Status Badge --}}
                @if($statusCoupon == 'Aktif')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[14px] font-semibold bg-green-700 text-white">
                    {{ $statusCoupon }}
                </span>
                @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[14px] font-semibold bg-red-700 text-white">
                    {{ $statusCoupon }}
                </span>
                @endif

                {{-- Nomor Kupon --}}
                <div class="space-y-1">
                    <p class="text-[12px] text-gray-500 font-medium tracking-wide uppercase">
                        Nomor Kupon Undian Kamu
                    </p>
                    <p class="text-3xl font-extrabold text-[#1E5BD8] leading-tight">
                        {{ $couponNumber }}
                    </p>
                </div>

                {{-- Detail Peserta --}}
                <div class="mt-2 space-y-1 text-[14px]">
                    <div class="flex justify-between gap-4">
                        <div>
                            <p class="text-gray-500">Nama peserta</p>
                            <p class="text-gray-800 font-semibold">
                                {{ $detailData['nama'] ?? 'tidak ada' }}
                            </p>
                        </div>
                        <div class="text-start">
                            <p class="text-gray-500">NIP</p>
                            <p class="text-gray-800 font-semibold text-[12px] leading-snug">
                                {{ $detailData['nip'] ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-2">
                        <p class="text-gray-500">Asal Instansi</p>
                        <p class="text-gray-800 font-semibold text-[14px]">
                            {{ Str::words($detailData['unit_kerja'] ?? '-', 20, '....') }}
                        </p>
                    </div>
                </div>

                <div class="relative my-6">
                    <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-7 h-7 bg-white rounded-full"></div>
                    <div class="absolute -right-6 top-1/2 -translate-y-1/2 w-7 h-7 bg-white rounded-full"></div>
                    <div class="border-t-2 border-dashed border-white"></div>
                </div>

                {{-- Tukarkan kupon belum berfungsi --}}
                <livewire:peserta.reedem-toko />


                <button type="button" wire:click="downloadCoupon" wire:loading.attr="disabled"
                    wire:loading.class="opacity-75 cursor wait"
                    class="w-full bg-[#5065A4] text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center">
                    <span wire:loading.remove wire:target="downloadCoupon">Download Doorprize</span>

                    <span wire:loading wire:target="downloadCoupon" class="flex items-center gap-1">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        {{-- Banner Foto Doorprize --}}
        <div id="bannerWrapper"
            style="width:100%; height:182px; overflow:hidden; border-radius:16px; margin-bottom:16px; position:relative;">

            @foreach ($banners as $banner)
                <img src="{{ $banner['image'] }}" alt="{{ $banner['title'] }}" class="banner-slide"
                    style="width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0; opacity:{{ $loop->first ? '1' : '0' }}; transition:opacity 0.6s;">
            @endforeach
        </div>

        <p class="text-sm text-gray-400 text-center mb-2">*Gambar Doorprize Hanya Ilustrasi</p>
        {{-- Dot indicators --}}
        <div id="bannerDots" class="mb-8" style="display:flex; justify-content:center; gap:4px;">
            @foreach ($banners as $banner)
                <span
                    style="width:8px; height:8px; border-radius:9999px; background:{{ $loop->first ? '#6b7280' : '#d1d5db' }}; transition:background-color 0.3s;">
                </span>
            @endforeach
        </div>

        {{-- Fitur logout --}}
        {{-- <button type="button" wire:click="logout" wire:loading.attr="disabled"
            wire:loading.class="opacity-75 cursor wait"
            class="w-full border-2 border-red-600 text-red-600 font-bold py-3.5 rounded-xl shadow-lg hover:bg-red-600 hover:text-white hover:shadow-xl hover:-translate-y-0.5 transform transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center mb-4">

            <div class="flex gap-2">
                <svg  wire:loading.remove wire:target="logout" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-logout"> 
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M9 12h12l-3 -3" />
                    <path d="M18 15l3 -3" />
                </svg>
                <span wire:loading.remove wire:target="logout">Keluar dari aplikasi</span>
            </div>

            <span wire:loading wire:target="logout" class="flex items-center gap-1">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </span>
        </button> --}}

        {{-- Logo Footer --}}
        <div class="mt-4 flex justify-center gap-6 items-center">
            <x-peserta.logo />
        </div>

    </div>

    <script>
        // Slider animation banner Doorprize
        document.addEventListener('DOMContentLoaded', function() {

            const slides = document.getElementsByClassName('banner-slide');
            const dots = document.getElementById('bannerDots').children;

            if (!slides.length) return;

            let index = 0;
            const total = slides.length;

            function showSlide(i) {
                index = i % total;

                // Update slide visibility
                for (let s = 0; s < total; s++) {
                    slides[s].style.opacity = (s === index) ? '1' : '0';
                }

                // Update dots
                for (let d = 0; d < total; d++) {
                    dots[d].style.backgroundColor = (d === index) ? '#6b7280' : '#d1d5db';
                }
            }

            setInterval(() => {
                showSlide(index + 1);
            }, 3000);
        });
    </script>
</div>
