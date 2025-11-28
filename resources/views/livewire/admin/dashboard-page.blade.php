<div>
    <div class="page-wrapper bg-gray-100">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">

                    <div class="col">
                        <div class="text-uppercase text-muted font-weight-bold mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Overview
                        </div>
                        <h2 class="page-title fw-bold text-dark">
                            Dashboard Undian
                        </h2>
                    </div>

                    <div class="col-auto ms-auto d-print-none">
                        <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel"
                            class="btn btn-success d-flex align-items-center"> <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-file-spreadsheet me-2" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                <path d="M8 11h8v7h-8z"></path>
                                <path d="M8 15h8"></path>
                                <path d="M11 11v7"></path>
                            </svg>

                            <span wire:loading.remove wire:target="exportExcel">Export Excel</span>

                            <span wire:loading wire:target="exportExcel">
                                Downloading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards mb-4">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="subheader text-muted text-uppercase fw-bold mb-1">
                                            Total Peserta
                                        </div>

                                    </div>

                                    <div class="ms-auto lh-1">
                                        <span class="text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-users" width="48" height="48"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="h1 mb-0 fw-bold text-dark">
                                    {{ $stats['total'] }}
                                </div>
                                <div class="text-muted small mt-1">
                                    <span class="status-dot bg-success status-dot-animated"></span> Data
                                    Real-time
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader text-muted">Kupon Undian Aktif</div>
                                    <div class="ms-auto lh-1">
                                        <span class="text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 5l0 2" />
                                                <path d="M15 11l0 2" />
                                                <path d="M15 17l0 2" />
                                                <path
                                                    d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="h1 mb-3 mt-1 fw-bold">{{ $stats['activeCoupon'] }}</div>
                                <div class="text-muted">Tiket siap diundi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Konfigurasi</h3>
                                <div class="card-actions d-flex gap-2">
                                    <div class="ms-auto text-muted">
                                        <div class="ms-2 d-inline-block">
                                            <input type="text" class="form-control form-control"
                                                placeholder="Cari key atau value..."
                                                wire:model.live.debounce.300ms="search">
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-setting" wire:click="create">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                        Tambah Setting
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1">No.</th>
                                            <th>Key (Kunci)</th>
                                            <th>Value (Nilai)</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($settings as $index => $item)
                                        <tr wire:key="setting-{{ $item->id }}">
                                            <td><span class="text-muted">{{ $settings->firstItem() + $index }}</span>
                                            </td>

                                            <td>
                                                <span class="badge bg-blue-lt font-mono">
                                                    {{ $item->key }}
                                                </span>
                                            </td>

                                            <td class="text-wrap" style="max-width: 300px;">
                                                {{ Str::limit($item->value, 50) }}
                                            </td>

                                            <td class="text-end">
                                                <button class="btn btn-white btn-icon text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#modal-setting"
                                                    wire:click="edit({{ $item->id }})">
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
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <div class="empty">
                                                    <div class="empty-title">Data tidak ditemukan</div>
                                                    <p class="empty-subtitle text-muted">Belum ada konfigurasi yang
                                                        tersimpan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer d-flex align-items-center">
                                <p class="m-0 text-muted small">
                                    Showing <span>{{ $settings->firstItem() }}</span> to <span>{{ $settings->lastItem()
                                        }}</span> of <span>{{ $settings->total() }}</span> entries
                                </p>
                                <div class="ms-auto">
                                    {{ $settings->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal modal-blur fade" id="modal-setting" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content" wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isEditing ? 'Edit Konfigurasi' : 'Tambah Konfigurasi Baru' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Key (Kunci Pengaturan)</label>
                        <input type="text" class="form-control font-mono @error('key') is-invalid @enderror"
                            wire:model="key" placeholder="Contoh: status_absensi" {{ $isEditing ? 'readonly' : '' }}>
                        @if(!$isEditing)
                        <div class="form-text text-muted">Gunakan huruf kecil dan underscore (snake_case).</div>
                        @endif
                        @error('key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Value (Nilai)</label>
                        <textarea class="form-control @error('value') is-invalid @enderror" wire:model="value" rows="3"
                            placeholder="Contoh: buka"></textarea>
                        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                        wire:click="resetForm">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary ms-auto" wire:loading.attr="disabled">
                        <div wire:loading class="spinner-border spinner-border-sm me-2"></div>
                        {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (event) => {
                const modalEl = document.getElementById('modal-setting');
                if (modalEl) {
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.hide();
                }
            });
        });
    </script>
    @endscript
</div>