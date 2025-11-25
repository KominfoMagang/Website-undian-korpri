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
        <x-admin.navbar/>

        <div class="page-wrapper">
            {{ $slot }}

            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
                                        class="link-secondary" rel="noopener">Documentation</a></li>
                                <li class="list-inline-item"><a href="#" class="link-secondary">License</a>
                                </li>
                                <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank"
                                        class="link-secondary" rel="noopener">Source code</a></li>
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