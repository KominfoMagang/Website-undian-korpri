@props(['is_modal_open' => false, 'categories' => null])

<style>
  .modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1050;display:flex;justify-content:center;align-items:center;padding:20px;}
  .modal-content-doorprize{background:#fff;border-radius:8px;width:90%;max-width:600px;box-shadow:0 10px 25px rgba(0,0,0,0.2);max-height:90vh;overflow-y:auto;}
  .text-danger{color:#dc3545;font-size:0.875em;}
</style>

{{-- Alpine + entangle => two-way sinkron dengan Livewire parent --}}
<div x-data="{ open: @entangle('is_modal_open') }"
     x-show="open"
     x-cloak
     @keydown.escape.window="open = false; $wire.closeModal()"
     class="modal-overlay"
     x-bind:style="open ? 'display: flex' : 'display: none'"
     @click="open = false; $wire.closeModal()"
     id="modalHadiahOverlay">

    <div class="modal-content-doorprize" @click.stop>

        <div class="modal-header" style="padding:20px;border-bottom:1px solid #e9ecef;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;">Tambah Hadiah Baru</h3>

            <button type="button" @click="open = false; $wire.closeModal()"
                    style="background:none;border:none;font-size:28px;cursor:pointer;color:#6c757d;line-height:1;">
                &times;
            </button>
        </div>

        <div class="modal-body" style="padding:20px;">
            <form wire:submit.prevent="saveHadiah" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Nama Hadiah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model.defer="nama_hadiah" placeholder="Contoh: Jambal Roti">
                    @error('nama_hadiah') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- === UBAH INI: select kategori dinamis === -->
                <div class="mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-control" wire:model.defer="kategori_id">
                        <option value="">Pilih Kategori</option>

                        {{-- jika prop categories ada, pakai itu --}}
                        @if(!empty($categories) && $categories->count())
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                            @endforeach

                        {{-- fallback: kalau tidak ada prop, tampilkan pesan --}}
                        @else
                            <option value="" disabled>-- belum ada kategori --</option>
                        @endif
                    </select>
                    @error('kategori_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- === SELESAI UBAHAN === -->

                <div class="mb-3">
                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" min="0" wire:model.defer="stok" placeholder="Masukkan jumlah stok...">
                    @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Hadiah (Maks 2MB)</label>
                    <input type="file" class="form-control" wire:model="gambar_hadiah">
                    <div wire:loading wire:target="gambar_hadiah">Uploading...</div>

                    @if(!empty($gambar_hadiah))
                        <p class="mt-2">Preview:</p>
                        <img src="{{ $gambar_hadiah->temporaryUrl() ?? '' }}" style="max-width:150px;height:auto;border-radius:4px;">
                    @endif

                    @error('gambar_hadiah') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="display:flex;gap:12px;margin-top:24px;">
                    <button type="button" class="btn btn-secondary flex-fill" @click="open = false; $wire.closeModal()">Batal</button>

                    <button type="submit" class="btn btn-primary flex-fill">
                        <span wire:loading wire:target="saveHadiah">Menyimpan...</span>
                        <span wire:loading.remove wire:target="saveHadiah">Simpan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
