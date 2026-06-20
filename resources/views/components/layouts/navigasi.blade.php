{{-- Top Navigation Bar --}}
<nav class="navbar navbar-expand navbar-light bg-white shadow-sm px-4 py-2" style="border-bottom: 1px solid #e3e6f0; position: sticky; top: 0; z-index: 900;">

    {{-- Kiri: Nama Halaman --}}
    <div class="navbar-brand mr-auto">
        <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">
            @yield('page-title', 'Dashboard')
        </span>
    </div>

    {{-- Kanan: Info User & Dropdown --}}
    <ul class="navbar-nav ml-auto align-items-center">

        {{-- Notifikasi keterlambatan & pengajuan menunggu --}}
        @php
            $terlambat = \App\Models\Peminjaman::where('status_buku', 'dipinjam')
                ->where('tgl_jatuh_tempo', '<', \Carbon\Carbon::now())
                ->count();

            $menunggu = in_array(auth()->user()->role ?? '', ['pustakawan', 'kepala'])
                ? \App\Models\Peminjaman::where('status_buku', 'menunggu')->count()
                : 0;
        @endphp

        {{-- Badge: pengajuan menunggu verifikasi --}}
        @if($menunggu > 0)
        <li class="nav-item mr-2">
            <a href="{{ route('verifikasi-pengajuan') }}"
               class="btn btn-sm position-relative"
               title="{{ $menunggu }} pengajuan menunggu verifikasi"
               style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                <i class="fas fa-clipboard-list"></i>
                <span class="badge badge-danger"
                      style="position:absolute;top:-6px;right:-6px;font-size:0.6rem;padding:3px 5px;border-radius:50%;">
                    {{ $menunggu }}
                </span>
            </a>
        </li>
        @endif

        {{-- Badge: buku terlambat --}}
        @if($terlambat > 0)
        <li class="nav-item mr-3">
            <a href="{{ route('peminjaman') }}" class="btn btn-sm btn-warning position-relative" title="{{ $terlambat }} buku terlambat">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger" style="position: absolute; top: -6px; right: -6px; font-size: 0.6rem; padding: 3px 5px; border-radius: 50%;">{{ $terlambat }}</span>
            </a>
        </li>
        @endif

        {{-- User Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle-no-arrow d-flex align-items-center" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="gap: 8px;">
                {{-- Avatar bulat dengan inisial --}}
                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #4e73df, #2563eb); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                    {{ strtoupper(substr(auth()->user()->nama_user ?? auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="d-none d-sm-block" style="line-height: 1.2;">
                    <div class="font-weight-bold text-dark" style="font-size: 0.85rem; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ auth()->user()->nama_user ?? auth()->user()->name ?? 'User' }}
                    </div>
                    <div class="text-muted" style="font-size: 0.72rem; text-transform: capitalize;">
                        {{ auth()->user()->role ?? '' }}
                    </div>
                </div>
                <i class="fas fa-chevron-down ml-1 text-muted" style="font-size: 0.65rem;"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-1" aria-labelledby="userDropdown"
                 style="min-width: 200px; border-radius: 10px; overflow: hidden;">
                <div class="px-4 py-2 border-bottom bg-light">
                    <div class="font-weight-bold text-dark" style="font-size: 0.85rem;">{{ auth()->user()->nama_user ?? auth()->user()->name ?? 'User' }}</div>
                    <div class="text-muted" style="font-size: 0.75rem; text-transform: capitalize;">{{ auth()->user()->role ?? '' }}</div>
                </div>
                <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profil') }}">
                    <i class="fas fa-user-circle mr-2 text-primary"></i>
                    <span>Profil Saya</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin keluar?')) window.location.href=this.href;">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </li>
    </ul>
</nav>

<style>
    /* Hilangkan panah otomatis Bootstrap pada dropdown-toggle */
    .dropdown-toggle-no-arrow::after {
        display: none !important;
    }
</style>
