@props([
    'is_modal_open' => false,
    'category_id' => null,
    'nama_kategori' => null,
])

<style>
  .modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:1050; display:flex; justify-content:center; align-items:center; padding:20px; }
  .modal-overlay.hidden { display:none !important; }
  .modal-content-doorprize { background:#fff; border-radius:8px; width:90%; max-width:500px; box-shadow:0 10px 25px rgba(0,0,0,0.2); }
  .text-danger { color:#dc3545; font-size:0.875em; }
</style>

<div class="modal-overlay {{ $is_modal_open ? '' : 'hidden' }}"
     style="display: {{ $is_modal_open ? 'flex' : 'none' }};"
     wire:click="closeModal"
     id="modalCategory">

    <div class="modal-content-doorprize" onclick="event.stopPropagation()">
        <div class="modal-header" style="padding:20px;border-bottom:1px solid #e9ecef;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;">{{ $category_id ? 'Ubah Kategori' : 'Tambah Kategori Baru' }}</h3>
            <button wire:click="closeModal" style="background:none;border:none;font-size:28px;cursor:pointer;color:#6c757d;line-height:1;">&times;</button>
        </div>

        <div class="modal-body" style="padding:20px;">
            <form wire:submit.prevent="saveCategory">
                <input type="hidden" wire:model="category_id">

                <div class="mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model.defer="nama_kategori" placeholder="Contoh: Elektronik">
                    @error('nama_kategori') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="display:flex;gap:12px;margin-top:24px;">
                    <button type="button" class="btn btn-secondary flex-fill" wire:click="closeModal">Batal</button>
                    <button type="submit" class="btn btn-primary flex-fill">
                        <span wire:loading wire:target="saveCategory">Menyimpan...</span>
                        <span wire:loading.remove wire:target="saveCategory">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
