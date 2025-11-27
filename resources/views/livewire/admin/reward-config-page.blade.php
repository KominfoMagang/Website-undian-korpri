<div>
    <!-- HEADER HALAMAN -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Kategori & Hadiah</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- BODY HALAMAN & CARD DAFTAR HADIAH -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Hadiah</h3>
                    <div class="card-actions">
                        <button class="btn btn-primary" wire:click="openModal">
                            Tambah Hadiah
                        </button>
                    </div>
                </div>

                <!-- KONTEN TABEL DATA -->
                <div class="card-body">
                    @if(isset($rewards) && count($rewards) > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Hadiah</th>
                                        <th>Kategori ID</th>
                                        <th>Stok</th>
                                        <!-- BARU: Kolom Foto dipindahkan di sini -->
                                        <th>Foto</th> 
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rewards as $reward)
                                    <tr wire:key="{{ $reward->id }}">
                                        <td>{{ $reward->id }}</td>
                                        <td>{{ $reward->nama_hadiah }}</td>
                                        <td>{{ $reward->reward_category_id }}</td>
                                        <td>{{ $reward->stok }}</td>
                                        
                                        <!-- BARU: Data Foto dipindahkan di sini -->
                                        <td>
                                            @if($reward->gambar)
                                                <img src="{{ \Storage::url($reward->gambar) }}" alt="{{ $reward->nama_hadiah }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">Tidak ada</span>
                                            @endif
                                        </td>
                                        
                                        <td><span class="badge bg-{{ $reward->status_hadiah == 'Aktif' ? 'success' : 'danger' }}">{{ $reward->status_hadiah }}</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                wire:click="editReward({{ $reward->id }})">Ubah</button>
                                            
                                            <button class="btn btn-sm btn-outline-danger" 
                                                wire:click="deleteReward({{ $reward->id }})" 
                                                wire:confirm="Apakah Anda yakin ingin menghapus hadiah ini?"
                                                >Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada data hadiah yang ditemukan. Silakan tambahkan hadiah baru.</p>
                    @endif
                </div>
                <!-- END: KONTEN TABEL DATA -->
            </div>
        </div>
    </div>

    <!-- PANGGIL MODAL -->
   <x-admin.modal :is-modal-open="$is_modal_open" :categories="$categories" />

</div>