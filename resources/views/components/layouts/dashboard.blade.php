<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Doorprize Manager</title>
    <link href="{{ asset('tabler/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content-doorprize {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: #0054a6;
            background: #f8f9fa;
        }

        .preview-image {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .prize-image {
            max-width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
    </style>

    @livewireStyles
</head>

<body>
    <script src="{{ asset('tabler/dist/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href=".">
                        <img src="{{ asset('tabler/static/logo.svg') }}" width="110" height="32" alt="Tabler"
                            class="navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-none d-md-flex me-3">
                        <div class="btn-list">
                            <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                                </svg>
                                Source code
                            </a>
                            <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank"
                                rel="noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                </svg>
                                Sponsor
                            </a>
                        </div>
                    </div>
                    <div class="d-none d-md-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url({{ asset('tabler/static/avatars/000m.jpg') }})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Paweł Kuna</div>
                                <div class="mt-1 small text-muted">UI Designer</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item">Status</a>
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="openHadiahModal()">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l18 0"></path>
                                            <path
                                                d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4">
                                            </path>
                                            <path d="M12 11h0"></path>
                                            <path d="M12 15h0"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Atur Hadiah</span>
                                </a>
                            </li>
                            </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
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
                                        <label class="form-label">Nama Hadiah <span
                                                class="text-danger">*</span></label>
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
                                            <input type="file" id="fileInput" accept="image/*"
                                                style="display:none;" onchange="handleFileSelect(event)">
                                            <div id="uploadPlaceholder">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    style="margin:0 auto 12px; display:block; color:#6c757d;">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12"
                                                        y2="15"></line>
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
                                        <button class="btn btn-secondary flex-fill"
                                            onclick="closeHadiahModal()">Batal</button>
                                        <button class="btn btn-primary flex-fill"
                                            onclick="saveHadiah()">Simpan</button>
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
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
                                        class="link-secondary" rel="noopener">Documentation</a></li>
                                <li class="list-inline-item"><a href="#" class="link-secondary">License</a>
                                </li>
                                <li class="list-inline-item"><a href="https://github.com/tabler/tabler"
                                        target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2023
                                    <a href="." class="link-secondary">Tabler</a>.
                                    All rights reserved.
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary" rel="noopener">
                                        v1.0.0-beta19
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('tabler/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js?1684106062') }}" defer></script>

    @livewireScripts
</body>

</html>