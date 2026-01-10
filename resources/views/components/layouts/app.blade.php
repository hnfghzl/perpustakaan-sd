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
    <link rel="stylesheet" href="{{ asset('asset/mobile-responsive.css') }}">

    @livewireStyles

    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
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
            width: calc(100% - 250px);
        }

        .main-content.full-width {
            margin-left: 0;
            width: 100%;
        }

        /* Container Fluid - Mobile Fix */
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Responsive Tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            display: block;
            width: 100%;
        }

        /* Card Responsiveness */
        .card {
            margin-bottom: 1rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .card-body {
            padding: 1rem;
        }

        /* Button Groups - Mobile */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        /* Form Controls */
        .form-control, .form-select {
            max-width: 100%;
        }

        /* Menu Toggle Button */
        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1001;
            display: none;
            font-size: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Active Menu */
        .active {
            background-color: #495057 !important;
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            /* Sidebar - Hidden by default on mobile */
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 10px rgba(0,0,0,0.3);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            /* Main Content - Full width on mobile */
            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 60px; /* Space for toggle button */
            }

            /* Show menu toggle */
            .menu-toggle {
                display: block;
            }

            /* Container adjustments */
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            /* Card adjustments */
            .card-body {
                padding: 0.75rem;
            }

            /* Table - Make scrollable */
            .table {
                font-size: 0.875rem;
                min-width: 600px;
            }

            /* Stat Cards - Stack on mobile */
            .row > [class*='col-'] {
                margin-bottom: 1rem;
            }

            /* Form - Better spacing */
            .form-group {
                margin-bottom: 1rem;
            }

            /* Buttons - Full width on mobile */
            .btn-block-mobile {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            /* Modal - Better mobile view */
            .modal-dialog {
                margin: 0.5rem;
            }

            /* Alert positioning */
            .alert {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
            }

            /* Hide text in small buttons, show icons only */
            .btn-sm span.d-none-mobile {
                display: none;
            }

            /* Navigation bar adjustments */
            .navbar {
                padding-left: 60px; /* Space for menu button */
            }

            /* Dropdown menus */
            .dropdown-menu {
                min-width: 200px !important;
            }
        }

        @media (max-width: 576px) {
            /* Extra small devices */
            .table {
                font-size: 0.8rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }

            h3 {
                font-size: 1.1rem;
            }

            /* Card - Convert table to card view */
            .card-view-mobile {
                display: block;
            }

            .card-view-mobile .table {
                display: none;
            }
        }

        /* Utility Classes */
        .text-truncate-mobile {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .no-wrap {
            white-space: nowrap;
        }

        /* Print Styles */
        @media print {
            .sidebar,
            .menu-toggle,
            .navbar,
            .btn,
            .sidebar-overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    {{-- Sidebar Overlay (untuk close sidebar di mobile) --}}
    <div class="sidebar-overlay" onclick="closeSidebar()"></div>

    {{-- Tombol toggle sidebar (muncul di HP) --}}
    <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
        <i class="fas fa-bars"></i>
    </button>

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

        // Toggle Sidebar Function
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Close Sidebar Function
        function closeSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }

        // Close sidebar when clicking a link (mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });
        });

        // Auto-hide alert setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>
</body>

</html>