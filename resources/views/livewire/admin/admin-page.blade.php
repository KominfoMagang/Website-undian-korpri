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
                            <h3 class="card-title">Data Admin</h3>
                            <div class="card-actions d-flex gap-2">
                                <div class="ms-auto text-muted">
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control" placeholder="Cari admin..."
                                            wire:model.live.debounce.500ms="search">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn" data-bs-toggle="modal"
                                    data-bs-target="#modal-create-admin">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Admin
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $index => $item)
                                    <tr wire:key="admin-{{ $item->id }}">
                                        <td><span class="text-muted">{{ $admins->firstItem() + $index }}</span></td>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <span class="avatar me-2 bg-blue-lt relative">
                                                    {{ substr($item->nama, 0, 1) }}

                                                    @if($item->isOnline())
                                                    <span class="badge bg-success badge-notification border-white"
                                                        style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; padding: 0; border-radius: 50%;"></span>
                                                    @endif
                                                </span>

                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">
                                                        {{ $item->nama }}
                                                        @if($item->isOnline())
                                                        <span class="text-success text-xs ms-1">(Online)</span>
                                                        @endif
                                                    </div>

                                                    @if($item->id == auth()->id())
                                                    <div class="text-muted text-xs">Anda</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->username }}</td>
                                        <td class="text-end">
                                            @if($item->id != auth()->id())
                                            <a href="#" class="btn btn-white btn-icon text-danger"
                                                data-bs-toggle="modal" data-bs-target="#modal-danger"
                                                wire:click="setDeleteId({{ $item->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Data tidak ditemukan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal modal-blur fade" id="modal-create-admin" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content" wire:submit="store">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama"
                            placeholder="Nama Admin">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            wire:model="username" placeholder="Username untuk login">
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            wire:model="password" placeholder="Password minimal 6 karakter">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                        wire:click="resetForm">Batal</button>
                    <button type="submit" class="btn btn-primary ms-auto" wire:loading.attr="disabled">
                        <div wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></div>
                        Simpan
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 9v2m0 4v.01" />
                        <path
                            d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                    </svg>
                    <h3>Hapus Admin?</h3>
                    <div class="text-muted">Tindakan ini tidak dapat dibatalkan.</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Batal</a></div>
                            <div class="col">
                                <a href="#" class="btn btn-danger w-100" wire:click="delete" data-bs-dismiss="modal">Ya,
                                    Hapus</a>
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
                const modalCreate = document.getElementById('modal-create-admin');
                const modalDelete = document.getElementById('modal-danger');
                
                if(modalCreate) bootstrap.Modal.getOrCreateInstance(modalCreate).hide();
                if(modalDelete) bootstrap.Modal.getOrCreateInstance(modalDelete).hide();
            });
        });
    </script>
    @endscript
</div>