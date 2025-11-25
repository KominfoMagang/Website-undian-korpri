<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Doorprize Manager
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Akumulasi Pendaftar/Peserta terdaftar</h3>
                            <button class="btn btn-primary" style="border-radius:24px; padding:10px 18px;">
                                Mulai pengundian
                            </button>
                            <div id="chart-mentions" class="chart-lg"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Locations</h3>
                            <div class="ratio ratio-21x9">
                                <div>
                                    <div id="map-world" class="w-100 h-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Hadiah</h3>
                            <div class="card-actions">
                                <button class="btn btn-primary" onclick="openHadiahModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Hadiah
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama & Deskripsi</th>
                                        <th>Gambar</th>
                                        <th>Urutan Pengundian</th>
                                        <th style="text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="hadiahTableBody">
                                    <tr id="emptyState" style="display: table-row;">
                                        <td colspan="5" class="empty-state">
                                            <p class="h4">Belum ada hadiah terdaftar</p>
                                            <p class="text-muted">Klik tombol "Tambah Hadiah" untuk mulai
                                                mengatur hadiah doorprize Anda.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-overlay" id="modalHadiahOverlay">
                    <div class="modal-content-doorprize">
                        <div class="modal-header"
                            style="padding:20px; border-bottom:1px solid #e9ecef; display:flex; justify-content:space-between; align-items:center;">
                            <h3 style="margin:0;">Tambah Hadiah Baru</h3>
                            <button onclick="closeHadiahModal()"
                                style="background:none; border:none; font-size:28px; cursor:pointer; color:#6c757d; line-height:1;">&times;</button>
                        </div>
                        <div class="modal-body" style="padding:20px;">
                            <div class="mb-3">
                                <label class="form-label">Nama Hadiah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namaHadiah"
                                    placeholder="Contoh: Jambal Roti">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi (opsional)</label>
                                <textarea class="form-control" id="deskripsiHadiah" rows="3"
                                    placeholder="Deskripsi singkat hadiah..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar Hadiah</label>
                                <div class="upload-area" id="uploadArea"
                                    onclick="document.getElementById('fileInput').click()">
                                    <input type="file" id="fileInput" accept="image/*" style="display:none;"
                                        onchange="handleFileSelect(event)">
                                    <div id="uploadPlaceholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="margin:0 auto 12px; display:block; color:#6c757d;">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                        <p style="margin:0; color:#6c757d;">Klik untuk upload gambar</p>
                                        <p style="margin:4px 0 0; font-size:12px; color:#9ca3af;">PNG, JPG,
                                            JPEG (Max 5MB)</p>
                                    </div>
                                    <div id="previewArea" style="display:none;">
                                        <img id="previewImage" class="preview-image" alt="Preview">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="removeImage(event)">Hapus Gambar</button>
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex; gap:12px; margin-top:24px;">
                                <button class="btn btn-secondary flex-fill" onclick="closeHadiahModal()">Batal</button>
                                <button class="btn btn-primary flex-fill" onclick="saveHadiah()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Data hadiah
                            let hadiahList = [];
                            let currentImageData = null;

                            // Fungsi buka modal (DIKOREKSI NAMANYA)
                            function openHadiahModal() {
                                document.getElementById('modalHadiahOverlay').classList.add('active');
                                resetForm();
                                renderTable(); // Memastikan tabel di dashboard ter-render ulang
                            }

                            // Fungsi tutup modal
                            function closeHadiahModal() {
                                document.getElementById('modalHadiahOverlay').classList.remove('active');
                                resetForm();
                            }

                            // Fungsi reset form
                            function resetForm() {
                                document.getElementById('namaHadiah').value = '';
                                document.getElementById('deskripsiHadiah').value = '';
                                currentImageData = null;
                                document.getElementById('uploadPlaceholder').style.display = 'block';
                                document.getElementById('previewArea').style.display = 'none';
                                if (document.getElementById('fileInput')) {
                                    document.getElementById('fileInput').value = '';
                                }
                            }

                            // Fungsi handle file upload
                            function handleFileSelect(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    // Validasi ukuran file (max 5MB)
                                    if (file.size > 5 * 1024 * 1024) {
                                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                                        document.getElementById('fileInput').value = '';
                                        return;
                                    }

                                    // Validasi tipe file
                                    if (!file.type.match('image.*')) {
                                        alert('File harus berupa gambar!');
                                        document.getElementById('fileInput').value = '';
                                        return;
                                    }

                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        currentImageData = e.target.result;
                                        document.getElementById('previewImage').src = currentImageData;
                                        document.getElementById('uploadPlaceholder').style.display = 'none';
                                        document.getElementById('previewArea').style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }

                            // Fungsi hapus gambar
                            function removeImage(event) {
                                event.stopPropagation();
                                currentImageData = null;
                                document.getElementById('uploadPlaceholder').style.display = 'block';
                                document.getElementById('previewArea').style.display = 'none';
                                document.getElementById('fileInput').value = '';
                            }

                            // Fungsi simpan hadiah
                            function saveHadiah() {
                                const nama = document.getElementById('namaHadiah').value.trim();

                                if (!nama) {
                                    alert('Nama hadiah harus diisi!');
                                    return;
                                }

                                const hadiah = {
                                    id: Date.now(),
                                    nama: nama,
                                    deskripsi: document.getElementById('deskripsiHadiah').value.trim(),
                                    gambar: currentImageData
                                };

                                hadiahList.push(hadiah);
                                renderTable();
                                closeHadiahModal();

                                // Optional: Tampilkan notifikasi sukses
                                // alert('Hadiah berhasil ditambahkan!'); // Dihapus agar tidak mengganggu
                            }

                            // Fungsi hapus hadiah
                            function deleteHadiah(id) {
                                if (confirm('Apakah Anda yakin ingin menghapus hadiah ini?')) {
                                    hadiahList = hadiahList.filter(h => h.id !== id);
                                    renderTable();
                                }
                            }

                            // Fungsi render tabel
                            function renderTable() {
                                const tbody = document.getElementById('hadiahTableBody');
                                
                                // Hapus semua baris kecuali empty state
                                let rows = Array.from(tbody.children).filter(child => child.id !== 'emptyState');
                                rows.forEach(row => row.remove());

                                const emptyState = document.getElementById('emptyState');

                                if (hadiahList.length === 0) {
                                    emptyState.style.display = 'table-row';
                                    return;
                                }

                                emptyState.style.display = 'none';

                                const newRows = hadiahList.map((hadiah, index) => `
                                    <tr>
                                        <td>${index + 1}.</td>
                                        <td>
                                            <div style="font-weight:600;">${hadiah.nama}</div>
                                            ${hadiah.deskripsi ? `<div class="text-muted small">${hadiah.deskripsi}</div>` : ''}
                                        </td>
                                        <td>
                                            ${hadiah.gambar 
                                                ? `<img src="${hadiah.gambar}" class="prize-image" alt="${hadiah.nama}">` 
                                                : `<div style="max-width:120px; height:80px; border-radius:8px; background:#e6e9ee; display:flex; align-items:center; justify-content:center; color:#6c757d; font-size:12px;">No Image</div>`
                                            }
                                        </td>
                                        <td>
                                            <div style="background:#fff; border-radius:16px; padding:6px 12px; box-shadow:0 6px 20px rgba(0,0,0,0.06); display:inline-block;">
                                                Urutan ke-${index + 1}
                                            </div>
                                        </td>
                                        <td style="text-align:center;">
                                            <button class="btn btn-sm btn-danger" onclick="deleteHadiah(${hadiah.id})" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('');
                                
                                // Menambahkan baris baru setelah emptyState
                                emptyState.insertAdjacentHTML('afterend', newRows);
                            }
                            
                            // Menghapus fungsi getOrdinalSuffix karena sudah diubah menjadi 'Urutan ke-'
                            // function getOrdinalSuffix(num) { ... }

                            // Tutup modal jika klik di luar
                            document.getElementById('modalHadiahOverlay').addEventListener('click', function(e) {
                                const modalContent = document.querySelector('.modal-content-doorprize');
                                if (e.target === this) {
                                    closeHadiahModal();
                                }
                            });

                            // Initial render saat halaman dimuat
                            document.addEventListener('DOMContentLoaded', function() {
                                renderTable();
                            });
                </script>
            </div>
        </div>
    </div>
</div>