<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Anggota – Perpustakaan</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/Logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles

    <style>
        :root {
            --primary:      #3b82f6;
            --primary-dark: #2563eb;
            --bg:           #f8fafc;
            --card-bg:      #ffffff;
            --text:         #1e293b;
            --muted:        #64748b;
            --border:       #e5e7eb;
            --sidebar-w:    220px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            min-height: 100vh;
        }

        /* ─── Navbar ─── */
        .portal-navbar {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 0 1.5rem;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(59,130,246,.35);
            position: sticky;
            top: 0;
            z-index: 200;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .hamburger-btn {
            display: none;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: #fff;
            border-radius: 7px;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: .95rem;
            flex-shrink: 0;
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            text-decoration: none;
            letter-spacing: .01em;
        }
        .portal-brand:hover { color: #fff; text-decoration: none; }
        .portal-brand img {
            width: 46px; height: 46px;
            object-fit: contain;
            border-radius: 8px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,.18);
        }
        .portal-brand span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 340px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .navbar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            border: 2px solid rgba(255,255,255,.4);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .82rem; color: #fff;
            flex-shrink: 0;
        }

        .navbar-username {
            font-size: .84rem;
            font-weight: 500;
            color: rgba(255,255,255,.9);
        }

        .btn-logout {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff;
            border-radius: 7px;
            padding: .3rem .75rem;
            font-size: .82rem;
            font-weight: 500;
            cursor: pointer;
            transition: background .2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-logout:hover { background: rgba(255,255,255,.28); color: #fff; text-decoration: none; }

        /* ─── Page Wrapper ─── */
        .portal-wrapper {
            display: flex;
            min-height: calc(100vh - 68px);
        }

        /* ─── Sidebar ─── */
        .portal-sidebar {
            width: var(--sidebar-w);
            background: #fff;
            border-right: 1px solid var(--border);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 1.1rem 0 2rem;
            position: sticky;
            top: 68px;
            height: calc(100vh - 68px);
            overflow-y: auto;
        }

        .sidebar-section-label {
            font-size: .67rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .4rem 1.1rem .25rem;
            margin-top: .25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .65rem 1.1rem;
            color: var(--muted);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .14s;
        }
        .sidebar-link:hover {
            background: #eff6ff;
            color: var(--primary);
            text-decoration: none;
            border-left-color: #bfdbfe;
        }
        .sidebar-link.active {
            background: #dbeafe;
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .sidebar-link i {
            width: 17px;
            text-align: center;
            font-size: .88rem;
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: .6rem 0;
        }

        /* ─── Main Content ─── */
        .portal-main {
            flex: 1;
            min-width: 0;
            padding: 1.5rem 1.5rem 3rem;
        }

        /* ─── Flash Alerts ─── */
        .flash-zone { margin-bottom: 1rem; }

        /* ─── Sidebar Overlay (mobile) ─── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 150;
        }
        .sidebar-overlay.show { display: block; }

        /* ─── Mobile ─── */
        @media (max-width: 767px) {
            .hamburger-btn { display: flex; }

            .portal-sidebar {
                position: fixed;
                left: -240px;
                top: 0;
                height: 100vh;
                z-index: 160;
                transition: left .25s ease;
                padding-top: 76px;
                box-shadow: 4px 0 24px rgba(0,0,0,.15);
                width: 230px;
            }
            .portal-sidebar.open { left: 0; }

            .portal-main { padding: 1rem .85rem 4rem; }

            .portal-brand span { display: none; }
            .navbar-username { display: none; }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="portal-navbar">
        <div class="navbar-left">
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('anggota.portal') }}" class="portal-brand">
                <img src="{{ asset('asset/Logo.png') }}" alt="Logo">
                <span>PERPUSTAKAAN SD MUHAMMADIYAH KARANGWARU</span>
            </a>
        </div>
        <div class="navbar-right">
            @if(Auth::guard('anggota')->check())
                <a href="{{ route('anggota.profil') }}" title="Profil &amp; Ganti Password"
                   style="display:flex;align-items:center;gap:.5rem;text-decoration:none;padding:.25rem .5rem;border-radius:8px;transition:background .15s;"
                   onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='transparent'">
                    <div class="navbar-avatar">
                        {{ strtoupper(substr(Auth::guard('anggota')->user()->nama_anggota, 0, 1)) }}
                    </div>
                    <span class="navbar-username">{{ Auth::guard('anggota')->user()->nama_anggota }}</span>
                </a>
            @endif
            <a href="{{ route('anggota.logout') }}" class="btn-logout">
                <i class="fas fa-sign-out-alt mr-1"></i> Keluar
            </a>
        </div>
    </nav>

    {{-- Overlay mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="portal-wrapper">
        {{-- Sidebar --}}
        <aside class="portal-sidebar" id="portalSidebar">
            @php
                $currentTab = request()->get('tab', 'katalog');
                $isPortal   = request()->routeIs('anggota.portal');
                $isProfil   = request()->routeIs('anggota.profil');
            @endphp

            <div class="sidebar-section-label">Menu</div>

            <a href="{{ route('anggota.portal') }}"
               class="sidebar-link {{ $isPortal && $currentTab === 'katalog' ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Katalog Buku
            </a>
            <a href="{{ route('anggota.portal') }}?tab=riwayat"
               class="sidebar-link {{ $isPortal && $currentTab === 'riwayat' ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </a>
        </aside>

        {{-- Main Content --}}
        <main class="portal-main">
            <div class="flash-zone">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
            </div>

            {{ $slot }}
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @livewireScripts
    <script>
        function toggleSidebar() {
            document.getElementById('portalSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>
</body>
</html>
