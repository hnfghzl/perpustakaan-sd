{{-- Summary Cards dengan Gradient & Animasi - SAMA SEPERTI DASHBOARD KEPALA --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card modern-card card-gradient-primary h-100 border-0 shadow-lg hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box icon-float bg-white bg-opacity-25 rounded-4 p-3 shadow-sm">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg> +12%
                    </span>
                </div>
                <h2 class="text-white fw-bold mb-2 counter" data-target="{{ $x['totalAnggota'] ?? 0 }}">0</h2>
                <p class="text-white text-opacity-75 mb-2 fw-semibold">Total Anggota</p>
                <div class="d-flex gap-2 text-white text-opacity-75">
                    <small>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg> Guru: {{ $x['totalGuru'] ?? 0 }}
                    </small>
                    <small>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg> Siswa: {{ $x['totalSiswa'] ?? 0 }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card modern-card card-gradient-success h-100 border-0 shadow-lg hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box icon-float bg-white bg-opacity-25 rounded-4 p-3 shadow-sm">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            <line x1="12" y1="3" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg> Aktif
                    </span>
                </div>
                <h2 class="text-white fw-bold mb-2 counter" data-target="{{ $x['totalBuku'] ?? 0 }}">0</h2>
                <p class="text-white text-opacity-75 mb-2 fw-semibold">Total Buku</p>
                <small class="text-white text-opacity-75">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg> Koleksi tersedia
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card modern-card card-gradient-warning h-100 border-0 shadow-lg hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box icon-float bg-white bg-opacity-25 rounded-4 p-3 shadow-sm">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="9" x2="15" y2="9"></line>
                            <line x1="9" y1="13" x2="15" y2="13"></line>
                            <line x1="9" y1="17" x2="13" y2="17"></line>
                        </svg>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white pulse">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg> Live
                    </span>
                </div>
                <h2 class="text-white fw-bold mb-2 counter" data-target="{{ $x['peminjamanAktif'] ?? 0 }}">0</h2>
                <p class="text-white text-opacity-75 mb-2 fw-semibold">Peminjaman Aktif</p>
                <small class="text-white text-opacity-75">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg> Buku sedang dipinjam
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card modern-card card-gradient-danger h-100 border-0 shadow-lg hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box icon-float bg-white bg-opacity-25 rounded-4 p-3 shadow-sm">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            <circle cx="18" cy="8" r="3" fill="#ff4444"></circle>
                        </svg>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; display: inline-block;">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg> Alert
                    </span>
                </div>
                <h2 class="text-white fw-bold mb-2 counter" data-target="{{ $x['bukuTerlambat'] ?? 0 }}">0</h2>
                <p class="text-white text-opacity-75 mb-2 fw-semibold">Buku Terlambat</p>
                <small class="text-white text-opacity-75">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <line x1="9" y1="14" x2="15" y2="20"></line>
                        <line x1="15" y1="14" x2="9" y2="20"></line>
                    </svg> Melewati jatuh tempo
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Info Card Modern - Gabung dalam 1 Card seperti Dashboard Kepala --}}
<div class="row g-4">
    <div class="col-12">
        <div class="card modern-card border-0 shadow-lg">
            <div class="card-header bg-gradient-warning text-white border-0 py-3">
                <h5 class="mb-0 fw-semibold">
                    <i data-feather="info" style="width: 20px; height: 20px;"></i> 
                    Informasi Sistem
                </h5>
            </div>
            <div class="card-body p-4" style="background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%);">
                <div class="row g-3">
                    {{-- Total Admin --}}
                    <div class="col-md-4">
                        <div class="info-item d-flex align-items-center p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.7); border-left: 4px solid #007bff;">
                            <div class="icon-wrapper me-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i data-feather="user-check" class="text-primary" style="width: 28px; height: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Total Admin</p>
                                <h4 class="mb-0 fw-bold text-primary">{{ $x['totalAdmin'] ?? 0 }}</h4>
                                <small class="text-muted">Pengguna sistem</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Hari Ini --}}
                    <div class="col-md-4">
                        <div class="info-item d-flex align-items-center p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.7); border-left: 4px solid #28a745;">
                            <div class="icon-wrapper me-3">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i data-feather="calendar" class="text-success" style="width: 28px; height: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Hari Ini</p>
                                <h5 class="mb-0 fw-bold text-success">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h5>
                                <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Login Info --}}
                    <div class="col-md-4">
                        <div class="info-item d-flex align-items-center p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.7); border-left: 4px solid #ffc107;">
                            <div class="icon-wrapper me-3">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i data-feather="user" class="text-warning" style="width: 28px; height: 28px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Login Sebagai</p>
                                <h5 class="mb-1 fw-bold text-dark">{{ Auth::user()->nama_user }}</h5>
                                <span class="badge bg-success px-3 py-1">
                                    <i data-feather="shield" style="width: 12px; height: 12px;"></i> Pustakawan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modern Dashboard CSS - SAMA SEPERTI DASHBOARD KEPALA --}}
<style>
    /* Modern Card Styling */
    .modern-card {
        border-radius: 1rem !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Gradient Backgrounds */
    .card-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .card-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .card-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    }

    /* Icon Box Animations */
    .icon-box {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .icon-float {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-10px) rotate(2deg);
        }
    }

    .icon-box:hover {
        transform: scale(1.15) rotate(-5deg);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
    }

    .icon-box svg {
        transition: all 0.3s ease;
    }

    .icon-box:hover svg {
        filter: drop-shadow(0 0 8px rgba(255,255,255,0.5));
        transform: scale(1.1);
    }

    /* Hover Lift Effect */
    .hover-lift {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
    }

    .hover-lift:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25) !important;
    }

    /* Counter Animation */
    .counter {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Pulse Animation for Badge */
    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Feather Icons Fix - Pastikan SVG muncul */
    [data-feather] {
        display: inline-block !important;
        vertical-align: middle;
    }

    [data-feather] svg {
        width: inherit !important;
        height: inherit !important;
    }

    .icon-box svg,
    .badge svg,
    .card-header svg {
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    /* Info Item Hover */
    .info-item {
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Card Shadow */
    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    /* Responsive Typography */
    @media (max-width: 768px) {
        .modern-card h2 {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function untuk refresh feather dengan multiple attempts
        function refreshFeatherIcons() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        
        // Multiple refresh attempts
        refreshFeatherIcons(); // Immediate
        setTimeout(refreshFeatherIcons, 100); // After 100ms
        setTimeout(refreshFeatherIcons, 300); // After 300ms
        setTimeout(refreshFeatherIcons, 500); // After 500ms
        
        // MutationObserver untuk auto-refresh
        const observer = new MutationObserver(() => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 1500;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            setTimeout(() => {
                updateCounter();
            }, 300);
        });
    });
    
    // Livewire hook untuk refresh icons setelah update
    document.addEventListener('livewire:navigated', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
