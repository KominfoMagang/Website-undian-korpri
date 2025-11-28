<div>
    <div class="py-3">
        @if ($isRedeemed)

            {{-- 1) SUDAH DITUKAR & SUDAH DIKLAIM TOKO --}}
            @if ($isClaimedByStore)
                <div class="mt-3 animate-fade-in-up">
                    <button type="button" style="cursor:not-allowed" disabled
                        class="w-full bg-[#FF383C] text-white text-sm font-bold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2">
                        Voucher Sudah Diklaim
                    </button>
                </div>

                {{-- 2) SUDAH DITUKAR & BELUM DIKLAIM TOKO --}}
            @else
                <div class="mt-3 animate-fade-in-up">
                    <button type="button" wire:click="showRedeemData"
                        class="w-full bg-[#7686BC] text-white text-sm font-bold py-3 rounded-xl shadow-lg hover:bg-[#3e5085] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Lihat Voucher Makanan
                    </button>
                </div>
            @endif

            {{-- KONDISI 3: BELUM DITUKAR (FORM INPUT) --}}
        @else
            @if (!$IslimitVoucher)
                <div class="text-gray-900 text-sm font-semibold">Tukarkan Voucher Makanan & Minuman</div>
                <div class="flex gap-2 mt-3 mb-2">
                    <div class="w-40">
                        <input type="text" inputmode="numeric" pattern="[0-9]{18}"
                            wire:model.live.debounce.250ms="kodeToko" maxlength="3" placeholder="Kode toko"
                            class="w-full bg-white rounded-lg p-3 text-sm font-semibold border border-transparent focus:border-blue-500 focus:outline-none transition-colors shadow-sm @error('kodeToko') @enderror">

                        @error('kodeToko')
                            <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="button" wire:click="reedemKuponToko" wire:loading.attr="disabled"
                        @disabled($isStokHabis)
                        class="w-60 bg-[#7686BC] text-white text-sm font-semibold py-3 rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed shadow-sm">
                        <span wire:loading.remove>
                            {{ $isStokHabis ? 'Stok Habis' : 'Tukar Voucher' }}
                        </span>
                        <span wire:loading>...</span>
                    </button>
                </div>
                @if ($isStokHabis)
                    <p class="text-red-500 text-sm mt-2 font-medium">
                        Stok kupon toko ini sudah habis. Silakan pilih toko lain.
                    </p>
                @endif
            @else
                <div class="flex items-center justify-center p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 shadow-sm"
                    role="alert">
                    <svg class="shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div>
                        <span class="font-bold">Mohon Maaf!</span> stok voucher makanan & minuman sudah mencapai batas 2000.
                    </div>
                </div>
            @endif
        @endif

    </div>

    {{-- ================== MODAL DETAIL / SUKSES ================== --}}
    @if ($showSuccessModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4 animate-fade-in">

            {{-- Backdrop Click to Close --}}
            <div class="absolute inset-0" wire:click="closeModal"></div>

            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all scale-100 p-6 text-center relative z-10">

                {{-- Tombol Close (X) di Pojok Kanan Atas --}}
                <button wire:click="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-1">Voucher berhasil ditukarkan</h3>
                <p class="text-gray-500 text-sm mb-6">
                    Silahkan Tunjukan Ke Penjual
                </p>

                <div class="mb-2">
                    <p class="text-gray-500 text-sm">Nama UMKM</p>
                    <h2 class="font-bold text-lg text-gray-800 text-center">{{ $nama_toko }}</h2>
                </div>
                <div class="mb-5">
                    <p class="text-gray-500 text-sm">Makanan & Minuman</p>
                    <h2 class="font-bold text-gray-800 tracking-wider text-lg text-center">{{ $jenis_produk }}</h2>
                </div>

                {{-- Btn di klik oleh penjual --}}

                <button type="button" wire:click="claimVoucherUmkm" wire:loading.attr="disabled"
                    wire:target="claimVoucherUmkm"
                    class="w-full bg-[#243672] text-white text-sm font-semibold py-4 rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 shadow-sm flex justify-center items-center gap-2">

                    <span wire:loading.remove wire:target="claimVoucherUmkm">
                        Klaim Voucher Oleh Toko
                    </span>

                    <div wire:loading wire:target="claimVoucherUmkm" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    @endif
</div>
