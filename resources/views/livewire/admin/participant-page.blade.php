<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Daftar Peserta
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
                            <h3 class="card-title">Data Peserta</h3>
                            <div class="card-actions d-flex gap-2">
                                <div class="ms-auto text-muted">
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control"
                                            placeholder="Cari NIP, Nama, Unit..."
                                            wire:model.live.debounce.500ms="search">
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create-user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Peserta
                                </a>
                                <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modal-import">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M8 11h8v7h-8z" />
                                        <path d="M8 15h8" />
                                        <path d="M11 11v7" />
                                    </svg>
                                    Import Excel
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Unit Kerja/Instansi</th>
                                        <th>Status Kehadiran</th>
                                        <th>Status Menang</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($participants as $index => $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td><span class="text-muted">{{ $participants->firstItem() + $index }}</span>
                                        </td>

                                        <td><a href="#" class="text-reset" tabindex="-1">{{ $item->nama }}</a></td>
                                        <td>{{ $item->nip }}</td>
                                        <td class="text-truncate" style="max-width: 200px;"
                                            title="{{ $item->unit_kerja }}">
                                            {{ $item->unit_kerja }}
                                        </td>

                                        <td>
                                            @if($item->status_hadir == 'Hadir')
                                            <span class="badge bg-success me-1"></span> Hadir
                                            @else
                                            <span class="badge bg-danger me-1"></span> Tidak Hadir
                                            @endif
                                        </td>

                                        <td>
                                            @if($item->sudah_menang)
                                            <span class="badge bg-yellow text-yellow-fg">Menang</span>
                                            @else
                                            Belum
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="#" class="btn btn-white btn-icon text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#modal-detail"
                                                    wire:click="showDetail({{ $item->id }})" title="Lihat Detail">
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
                                        <td colspan="8" class="text-center py-4">
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
                                Showing <span>{{ $participants->firstItem() }}</span> to <span>{{
                                    $participants->lastItem() }}</span> of <span>{{ $participants->total() }}</span>
                                entries
                            </p>

                            <div class="ms-auto">
                                {{ $participants->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-create-user" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                <form class="modal-content" wire:submit="store">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        wire:model.blur="nama" placeholder="Masukkan nama lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIP</label>
                                    <input type="text" maxlength="18" class="form-control @error('nip') is-invalid @enderror"
                                        wire:model.blur="nip" placeholder="Contoh: 19850101...">
                                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Unit Kerja / Instansi</label>
                            <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror"
                                wire:model.blur="unit_kerja" placeholder="Masukkan unit kerja/instansi">
                            @error('unit_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal" wire:click="resetForm">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary ms-auto">
                            <div wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></div>

                            <svg wire:loading.remove wire:target="store" xmlns="http://www.w3.org/2000/svg" class="icon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Simpan Data Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content" wire:submit="import">

                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Peserta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Pilih File Excel</label>
                            <input type="file" class="form-control @error('file_import') is-invalid @enderror"
                                wire:model="file_import" accept=".xlsx, .xls, .csv">

                            @error('file_import') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            <div wire:loading wire:target="file_import" class="text-primary mt-2 small">
                                Sedang mengunggah file ke server... Tunggu sebentar.
                            </div>

                            <small class="form-hint mt-2">
                                Header Excel wajib: <strong>NIP, NAMA, UNIT KERJA</strong>.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success ms-auto" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="import">Mulai Import</span>
                            <span wire:loading wire:target="import">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Sedang Memproses... Jangan tutup halaman!
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Detail Kehadiran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div wire:loading wire:target="showDetail" class="w-100 text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <div class="mt-2 text-muted">Memuat data...</div>
                        </div>

                        @if($selectedParticipant)
                        <div wire:loading.remove wire:target="showDetail">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Peserta</label>
                                        <p class="form-control-static">{{ $selectedParticipant->nama }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Foto Selfie</label>
                                        <img src="{{ $selectedParticipant->foto_url }}"
                                            class="img-fluid rounded border shadow-sm w-100 object-cover"
                                            style="max-height: 300px;" alt="Foto Peserta">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lokasi Presensi</label>
                                        <div class="d-flex gap-2 mb-2 text-muted small">
                                            <span>Lat: {{ $selectedParticipant->latitude }}</span>
                                            <span>Long: {{ $selectedParticipant->longitude }}</span>
                                        </div>

                                        @if($selectedParticipant->latitude && $selectedParticipant->longitude)
                                        <div class="ratio ratio-1x1"
                                            style="max-height: 300px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                                            <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                                marginheight="0" marginwidth="0"
                                                src="https://maps.google.com/maps?q={{ $selectedParticipant->latitude }},{{ $selectedParticipant->longitude }}&hl=id&z=17&output=embed">
                                            </iframe>
                                        </div>
                                        @else
                                        <div class="alert alert-warning">Lokasi tidak ditemukan.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
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
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (event) => {
            const modalEl = document.getElementById('modal-create-user');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.hide();
        });
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal-import', () => {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-import')).hide();
        });
    });
</script>
@endscript