<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    {{-- Bootstrap & Custom CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('asset/admin-dashboard.css') }}">

    @livewireStyles

    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        /* Konten utama */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #ffffff;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 101;
            display: none;
        }

        .active {
            background-color: #495057 !important;
        }
    </style>
</head>

<body>
    {{-- Tombol toggle sidebar (muncul di HP) --}}
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    {{-- Sidebar --}}
    @include('components.layouts.sidebar')

    {{-- Main Content --}}
    <div class="main-content">
        @include('components.layouts.navigasi')

        <div class="container-fluid mt-4">
            {{-- Alert untuk pesan flash --}}
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✓</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>✗</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session()->has('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>ℹ</strong> {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>⚠</strong> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    {{-- Script --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    @livewireScripts
    
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        // Cek apakah Livewire ter-load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Livewire !== 'undefined') {
                console.log('✅ Livewire loaded successfully!');
            } else {
                console.error('❌ Livewire NOT loaded!');
            }
        });

        feather.replace();

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }

        // Auto-hide alert setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000); // 5000ms = 5 detik
        });
    </script>
</body>

</html>