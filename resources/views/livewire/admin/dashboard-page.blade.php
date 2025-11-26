<div>
    <div class="page-wrapper bg-gray-100">
        <div class="page-header d-print-none mb-4 ">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-10">
                        <div class="text-uppercase text-muted font-weight-bold mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Overview
                        </div>
                        <h2 class="page-title fw-bold text-dark">
                            Dashboard Undian
                        </h2>
                    </div>
                    <div class="col-2">
                        <button wire:click="exportExcel" wire:loading.attr="disabled"
                            class="btn btn-success d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg"
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
                            <span wire:loading.remove target="exportExcel">Export Data Pemenang</span>
                            <span wire:loading target="exportExcel">Downloading...</span>
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
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
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
                </div>
            </div>
        </div>
    </div>
</div>
