<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Kategori & Hadiah</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div> @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>

                    <span class="ms-2">{{ session('message') }}</span>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <div class="row row-cards">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Data Kategori</h3>
                            <div class="card-actions d-flex gap-2">
                                <div class="ms-auto text-muted">
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control"
                                            placeholder="Cari Kategori..."
                                            wire:model.live.debounce.500ms="searchCategory">
                                    </div>
                                </div>

                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create-category" title="Tambah Kategori">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Kategori
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Nama Kategori</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $index => $item)
                                    <tr wire:key="cat-{{ $item->id }}">
                                        <td><span class="text-muted">{{ $categories->firstItem() + $index }}</span></td>
                                        <td>{{ $item->nama_kategori }}</td>
                                        <td class="text-end">
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                @if($item->rewards_count == 0)
                                                <a href="#" class="btn btn-white btn-icon text-danger"
                                                    data-bs-toggle="modal" data-bs-target="#modal-danger"
                                                    wire:click="setDeleteCategory({{ $item->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </a>
                                                @else
                                                <span
                                                    class="btn btn-white btn-icon text-muted cursor-not-allowed"
                                                    title="Tidak bisa dihapus karena memiliki {{ $item->rewards_count }} data hadiah">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-lock" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                    </svg>
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-title">Data tidak ditemukan</div>
                                                <p class="empty-subtitle text-muted">
                                                    Belum ada kategori.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted small">
                                Showing <span>{{ $categories->firstItem() }}</span>-<span>{{ $categories->lastItem()
                                    }}</span> of <span>{{ $categories->total() }}</span>
                            </p>
                            <div class="ms-auto">
                                {{ $categories->links(data: ['scrollTo' => false]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Data Hadiah</h3>
                            <div class="card-actions d-flex gap-2">
                                <div class="ms-auto text-muted">
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control"
                                            placeholder="Cari Nama Hadiah..."
                                            wire:model.live.debounce.500ms="searchReward">
                                    </div>
                                </div>

                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create-reward">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Hadiah
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Foto</th>
                                        <th>Nama Hadiah</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rewards as $index => $item)
                                    <tr wire:key="reward-{{ $item->id }}">
                                        <td><span class="text-muted">{{ $rewards->firstItem() + $index }}</span></td>

                                        <td>
                                            @if($item->gambar)
                                            <span class="avatar"
                                                style="background-image: url('{{ asset('storage/'.$item->gambar) }}')"></span>
                                            @else
                                            <span class="avatar bg-blue-lt">
                                                {{ substr($item->nama_hadiah, 0, 1) }}
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="font-weight-medium">{{ $item->nama_hadiah }}</div>
                                        </td>

                                        <td>
                                            {{ $item->category->nama_kategori ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->stok }}
                                        </td>

                                        <td>
                                            @if($item->status_hadiah == 'Aktif')
                                            <span class="badge bg-success me-1"></span> Aktif
                                            @else
                                            <span class="badge bg-danger me-1"></span> Tidak Aktif
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="#" class="btn btn-white btn-icon text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#modal-create-reward"
                                                    wire:click="editReward({{ $item->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-pencil" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                    </svg>
                                                </a>
                                                @if($item->status_hadiah == 'Tidak aktif')
                                                <a href="#" class="btn btn-white btn-icon text-danger"
                                                    data-bs-toggle="modal" data-bs-target="#modal-danger"
                                                    wire:click="setDeleteReward({{ $item->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-title">Data tidak ditemukan</div>
                                                <p class="empty-subtitle text-muted">
                                                    Coba ubah kata kunci pencarian Anda.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted small">
                                Showing <span>{{ $rewards->firstItem() }}</span>-<span>{{ $rewards->lastItem() }}</span>
                                of <span>{{ $rewards->total() }}</span>
                            </p>

                            <div class="ms-auto">
                                {{ $rewards->links(data: ['scrollTo' => false]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-create-category" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content" wire:submit="storeCategory">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Kategori</label>
                                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                        wire:model.blur="nama_kategori"
                                        placeholder="Contoh: Grand Prize, Hiburan, Utama..." autofocus>

                                    @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal" wire:click="resetForm">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary ms-auto" wire:loading.attr="disabled">

                            <div wire:loading wire:target="storeCategory" class="spinner-border spinner-border-sm me-2">
                            </div>

                            <svg wire:loading.remove wire:target="storeCategory" xmlns="http://www.w3.org/2000/svg"
                                class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>

                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-create-reward" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                <form class="modal-content" wire:submit="{{ $isEditing ? 'updateReward' : 'storeReward' }}">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $isEditing ? 'Edit Data Hadiah' : 'Tambah Hadiah Baru' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-12 mb-4">
                                <label class="form-label">Foto Hadiah</label>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if($gambar)
                                        <span class="avatar avatar-xl"
                                            style="background-image: url('{{ $gambar->temporaryUrl() }}')"></span>
                                        @elseif($oldGambar)
                                        <span class="avatar avatar-xl"
                                            style="background-image: url('{{ asset('storage/'.$oldGambar) }}')"></span>
                                        @else
                                        <span class="avatar avatar-xl bg-secondary-lt">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 8h.01" />
                                                <path
                                                    d="M11.5 21h-5.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5" />
                                                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l2 2" />
                                                <path
                                                    d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z" />
                                            </svg>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            wire:model="gambar" accept="image/*">
                                        <div class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</div>
                                        @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Hadiah</label>
                                    <input type="text" class="form-control @error('nama_hadiah') is-invalid @enderror"
                                        wire:model.blur="nama_hadiah" placeholder="Contoh: Kulkas 2 Pintu">
                                    @error('nama_hadiah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">Kategori Hadiah</label>
                                    <select class="form-select @error('reward_category_id') is-invalid @enderror"
                                        wire:model.change="reward_category_id">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('reward_category_id') <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                        wire:model.blur="stok" placeholder="0">
                                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">Status Hadiah</label>
                                    <select class="form-select @error('status_hadiah') is-invalid @enderror"
                                        wire:model.change="status_hadiah">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak aktif">Tidak aktif</option>
                                    </select>
                                    @error('status_hadiah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal" wire:click="resetForm">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" wire:loading.attr="disabled">
                            <div wire:loading wire:target="storeReward, updateReward, gambar"
                                class="spinner-border spinner-border-sm me-2"></div>
                            {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Data Baru' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v2m0 4v.01" />
                            <path
                                d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                        </svg>

                        <h3>
                            @if($deleteContext == 'category') Hapus Kategori?
                            @elseif($deleteContext == 'reward') Hapus Hadiah?
                            @else Apakah Anda yakin?
                            @endif
                        </h3>

                        <div class="text-muted">Data yang dihapus tidak dapat dikembalikan lagi.</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                        Batal
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-danger w-100" wire:click="delete"
                                        wire:loading.attr="disabled" data-bs-dismiss="modal"> <span wire:loading.remove
                                            wire:target="delete">Ya, Hapus</span>
                                        <span wire:loading wire:target="delete">Menghapus...</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (event) => {
            // Daftar ID semua modal yang ada di halaman ini
            const modalIds = [
                'modal-create-category', // Modal Tambah Kategori
                'modal-create-reward',   // Modal Tambah/Edit Hadiah
                'modal-danger'           // Modal Hapus
            ];

            // Loop untuk menutup modal yang sedang aktif
            modalIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    // Gunakan getOrCreateInstance agar lebih stabil
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(el);
                    modalInstance.hide();
                }
            });
        });
    });
</script>
@endscript