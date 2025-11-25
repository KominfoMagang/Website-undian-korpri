<div>
    <div class="w-full max-w-[420px]">
        <div class="bg-[#DDE2FF] rounded-3xl  overflow-hidden mb-6">

            {{-- Foto Selfie --}}
            <img src="{{ $banners[0]['image'] ?? 'static/images/bannerTest.svg' }}" alt="Selfie Peserta"
                class="w-full h-44 rounded-xl object-cover">

            <div class="p-4 space-y-3">

                {{-- Status Badge --}}
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[14px] font-semibold bg-green-700 text-white">
                    {{ $statusCoupon }}
                </span>

                {{-- Nomor Kupon --}}
                <div class="space-y-1">
                    <p class="text-[12px] text-gray-500 font-medium tracking-wide uppercase">
                        Nomor Kupon Undian Kamu
                    </p>
                    <p class="text-3xl font-extrabold text-[#1E5BD8] leading-tight">
                        {{ $couponNumber}}
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
                            {{ $detailData['unit_kerja'] ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="relative my-6">
                    <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-7 h-7 bg-white rounded-full"></div>
                    <div class="absolute -right-6 top-1/2 -translate-y-1/2 w-7 h-7 bg-white rounded-full"></div>
                    <div class="border-t-2 border-dashed border-white"></div>
                </div>

                <button type="button" wire:click="downloadCoupon"
                    class="w-full bg-[#5065A4] text-white text-sm font-semibold py-3 rounded-lg hover:opacity-90 transition-opacity">
                    Download kupon
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

        {{-- Dot indicators --}}
        <div id="bannerDots" style="display:flex; justify-content:center; gap:4px; margin-bottom:16px;">
            @foreach ($banners as $banner)
                <span
                    style="width:8px; height:8px; border-radius:9999px; background:{{ $loop->first ? '#6b7280' : '#d1d5db' }}; transition:background-color 0.3s;">
                </span>
            @endforeach
        </div>

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
