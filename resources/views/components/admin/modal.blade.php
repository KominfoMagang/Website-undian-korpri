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
                <input type="text" class="form-control" id="namaHadiah" placeholder="Contoh: Jambal Roti">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <textarea class="form-control" id="deskripsiHadiah" rows="3"
                    placeholder="Deskripsi singkat hadiah..."></textarea>
            </div>

            <div class="mb-3">
                <label for="inputStok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="inputStok" name="stok" min="0"
                    placeholder="Masukkan jumlah stok...">
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Hadiah</label>
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" accept="image/*" style="display:none;"
                        onchange="handleFileSelect(event)">
                    <div id="uploadPlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="margin:0 auto 12px; display:block; color:#6c757d;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15">
                            </line>
                        </svg>
                        <p style="margin:0; color:#6c757d;">Klik untuk upload gambar</p>
                        <p style="margin:4px 0 0; font-size:12px; color:#9ca3af;">PNG, JPG,
                            JPEG (Max 2MB)</p>
                    </div>
                    <div id="previewArea" style="display:none;">
                        <img id="previewImage" class="preview-image" alt="Preview">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeImage(event)">Hapus
                            Gambar</button>
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