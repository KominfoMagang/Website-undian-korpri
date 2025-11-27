<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Daftar Toko
                    </h2>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Toko</h3>
                            <div class="card-actions d-flex gap-2">
                                <div class="ms-auto text-muted">
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control"
                                            placeholder="Cari Kode, Nama Toko..."
                                            wire:model.live.debounce.500ms="search">
                                    </div>
                                </div>

                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create-store">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Toko
                                </a>

                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Kode Toko</th>
                                        <th>Nama Toko</th>
                                        <th>Jenis Produk</th>
                                        <th>Stok</th>
                                        <th>Jumlah Diklaim Peserta</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stores as $index => $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td><span class="text-muted">{{ $stores->firstItem() + $index }}</span>
                                        </td>

                                        <td>
                                            <span class="badge bg-blue text-blue-fg fs-3">{{ $item->kode_toko }}</span>
                                        </td>

                                        <td>
                                            {{ $item->nama_toko }}
                                        </td>

                                        <td>
                                            {{ $item->jenis_produk }}
                                        </td>

                                        <td>
                                            {{ $item->stok }}
                                        </td>

                                        <td>
                                            {{ $item->coupons_count }} Kupon
                                        </td>

                                        <td class="text-end">
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="#" class="btn btn-white btn-icon text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#modal-store-coupons"
                                                    wire:click="showStoreCoupons({{ $item->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-eye" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="btn btn-white btn-icon text-danger"
                                                    data-bs-toggle="modal" data-bs-target="#modal-danger"
                                                    wire:click="setDeleteId({{ $item->id }})">
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
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
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
                            <p class="m-0 text-muted">
                                Showing <span>{{ $stores->firstItem() }}</span> to <span>{{
                                    $stores->lastItem() }}</span> of <span>{{ $stores->total() }}</span>
                                entries
                            </p>

                            <div class="ms-auto">
                                {{ $stores->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div wire:ignore.self class="modal modal-blur fade" id="modal-create-store" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Toko Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form wire:submit.prevent="store">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label required">Nama Toko</label>
                                    <input type="text" class="form-control @error('nama_toko') is-invalid @enderror"
                                        wire:model="nama_toko" placeholder="Masukkan nama toko">
                                    @error('nama_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Kode Toko (3 Digit)</label>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control @error('kode_toko') is-invalid @enderror"
                                            wire:model="kode_toko" placeholder="Contoh: 123">

                                        <button class="btn" type="button" wire:click="generateKodeToko"
                                            wire:loading.attr="disabled">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                            </svg>
                                            Generate
                                        </button>
                                    </div>
                                    @error('kode_toko')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted">Klik tombol generate untuk membuat kode acak.
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary ms-auto" wire:loading.attr="disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
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
                            <h3>Apakah Anda yakin?</h3>
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
                                            data-bs-dismiss="modal">
                                            Ya, Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-blur fade" id="modal-store-coupons" tabindex="-1" role="dialog" aria-hidden="true"
                wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                @if($selectedStore)
                                List Kupon - {{ $selectedStore->nama_toko }}
                                <span class="badge bg-blue-lt ms-2">{{ $selectedStore->coupons->count() }} Item</span>
                                @else
                                Detail Kupon
                                @endif
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div wire:loading wire:target="showStoreCoupons" class="w-100 text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                                <div class="mt-2 text-muted">Sedang mengambil data...</div>
                            </div>

                            <div wire:loading.remove wire:target="showStoreCoupons">
                                @if($selectedStore)
                                @if($selectedStore->coupons->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="w-1">No.</th>
                                                <th>Kode Kupon</th>
                                                <th>Pemilik (Peserta)</th>
                                                <th>Status</th>
                                                <th>Tanggal Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selectedStore->coupons as $index => $kupon)
                                            <tr wire:key="modal-cpn-{{ $kupon->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="font-mono font-bold">{{ $kupon->kode_kupon }}</span>
                                                </td>
                                                <td>
                                                    @if($kupon->participant)
                                                    <div class="font-weight-medium">{{ $kupon->participant->nama }}
                                                    </div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">
                                                        {{ $kupon->participant->unit_kerja }}
                                                    </div>
                                                    @else
                                                    <span class="text-muted fst-italic">- Belum Diklaim -</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($kupon->status_kupon == 'Aktif')
                                                    <span class="badge bg-success me-1"></span> Aktif
                                                    @else
                                                    <span class="badge bg-secondary me-1"></span> {{
                                                    $kupon->status_kupon }}
                                                    @endif
                                                </td>
                                                <td class="text-muted">
                                                    {{ $kupon->created_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="12" cy="12" r="9" />
                                            <line x1="9" y1="10" x2="9.01" y2="10" />
                                            <line x1="15" y1="10" x2="15.01" y2="10" />
                                            <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                                        </svg>
                                    </div>
                                    <p class="empty-title">Belum ada data</p>
                                    <p class="empty-subtitle text-muted">
                                        Toko ini belum memiliki kupon yang terhubung.
                                    </p>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
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
            const modalEl = document.getElementById('modal-create-store');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.hide();
        });
    });
</script>
@endscript