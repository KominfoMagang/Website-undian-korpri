<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                <div class="d-flex align-items-center">
                    <img src="/static/images/bank_bjb.png" alt="Logo Kota Tasikmalaya"
                        class="navbar-brand-image img-hover-zoom me-3" style="height: 40px; width: auto;">

                    <img src="/static/images/logoKorpri.png" alt="Logo Korpri"
                        class="navbar-brand-image img-hover-zoom me-2" style="height: 40px; width: auto;">

                    <img src="/static/images/logoKotaTasik.png" alt="Logo Kota Tasikmalaya"
                        class="navbar-brand-image img-hover-zoom me-3" style="height: 40px; width: auto;">

                    <div class="d-none d-sm-block text-start lh-1">
                        <div class="text-uppercase fw-bold text-warning" style="font-size: 10px; letter-spacing: 2px;">
                            ASN DAY TAHUN 2025
                        </div>

                        <div class="fw-bolder text-reset text-uppercase" style="font-size: 14px; letter-spacing: 1px;">
                            Kota Tasikmalaya
                        </div>
                    </div>

                </div>
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('static/images/unknown_profile.png') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->nama }}</div>
                        <div class="mt-1 small text-muted">Admin</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>

<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="d-flex justify-content-between align-items-center w-full">
                    <ul class="navbar-nav flex-row gap-3">

                        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M13.45 11.55l2.05 -2.05" />
                                        <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title ms-1">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('admin.coupon') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.coupon') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
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
                                <span class="nav-link-title ms-1">Kupon</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('admin.participant*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.participant') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <span class="nav-link-title ms-1">Peserta</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('admin.reward-config') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.reward-config') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 8l8.172 -4.67a1 1 0 0 1 1.656 0l8.172 4.67a1 1 0 0 1 0 1.735l-8.172 4.671a1 1 0 0 1 -1.656 0l-8.172 -4.671a1 1 0 0 1 0 -1.735" />
                                        <path d="M3 12v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2 -2v-5" />
                                        <path d="M12 12v9" />
                                    </svg>
                                </span>
                                <span class="nav-link-title ms-1">Hadiah</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('admin.store') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.store') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21l18 0" />
                                        <path
                                            d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                                        <path d="M5 21l0 -10.15" />
                                        <path d="M19 21l0 -10.15" />
                                        <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                                    </svg>
                                </span>
                                <span class="nav-link-title ms-1">Toko</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('admin.admin') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.admin') }}" wire:navigate>
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-user-cog" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"></path>
                                        <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M19.001 15.5v1.5"></path>
                                        <path d="M19.001 21v1.5"></path>
                                        <path d="M22.032 17.25l-1.299 .75"></path>
                                        <path d="M17.27 20l-1.3 .75"></path>
                                        <path d="M15.97 17.25l1.3 .75"></path>
                                        <path d="M20.733 20l1.3 .75"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title ms-1">Admin</span>
                            </a>
                        </li>

                    </ul>

                    <div class="d-flex align-items-center gap-2 ms-auto d-print-none">

                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-konfirmasi-undian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dice me-2"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                <circle cx="8.5" cy="8.5" r=".5" fill="currentColor" />
                                <circle cx="15.5" cy="8.5" r=".5" fill="currentColor" />
                                <circle cx="15.5" cy="15.5" r=".5" fill="currentColor" />
                                <circle cx="8.5" cy="15.5" r=".5" fill="currentColor" />
                            </svg>
                            Mulai Pengundian
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <button class="btn btn-danger d-flex align-items-center"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout me-2"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2">
                                </path>
                                <path d="M9 12h12l-3 -3"></path>
                                <path d="M18 15l3 -3"></path>
                            </svg>
                            Logout
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

<div class="modal modal-blur fade" id="modal-konfirmasi-undian" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-warning"></div>

            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9v2m0 4v.01" />
                    <path
                        d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                </svg>
                <h3>Persiapan Undian</h3>
                <div class="text-muted">Apakah Anda ingin <strong>MENUTUP PRESENSI</strong> secara otomatis sebelum
                    masuk ke halaman undian?</div>
            </div>

            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('reward-system.undian') }}" target="_blank" class="btn btn-white w-100"
                                onclick="bootstrap.Modal.getInstance(document.getElementById('modal-konfirmasi-undian')).hide()">
                                Jangan Dulu
                            </a>
                        </div>

                        <div class="col">
                            <form action="{{ route('admin.close-attendance') }}" method="POST" target="_blank">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100"
                                    onclick="bootstrap.Modal.getInstance(document.getElementById('modal-konfirmasi-undian')).hide()">
                                    Tutup Presensi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>