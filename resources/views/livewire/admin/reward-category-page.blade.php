<div>
    {{-- Header --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manajemen Kategori Hadiah</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Kategori</h3>
                    <div class="card-actions">
                        <button class="btn btn-primary" wire:click="openModal">Tambah Kategori</button>
                    </div>
                </div>

                <div class="card-body">
                    @if(session()->has('success_message'))
                        <div class="alert alert-success">{{ session('success_message') }}</div>
                    @endif
                    @if(session()->has('error_message'))
                        <div class="alert alert-danger">{{ session('error_message') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Kategori</th>
                                <th style="width:160px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $i => $c)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $c->nama_kategori }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" wire:click="editCategory({{ $c->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click="deleteCategory({{ $c->id }})" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Panggil modal kategori (component blade) --}}
    <x-admin.modal-category :is_modal_open="$is_modal_open" />
</div>
