{{-- Single Root Element Wrapper for Livewire --}}
<div>
    {{-- Summary Cards with Teal Theme --}}
    <div class="row g-4 mb-4">
    {{-- Card 1: Total Anggota --}}
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
            onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(26, 188, 156, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
            onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
            
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(26, 188, 156, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(26, 188, 156, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                    <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(26, 188, 156, 0.3); animation: pulse 2s infinite;"></div>
                </div>
                <h2 style="font-size: 2.75rem; font-weight: 800; color: #1ABC9C; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $totalAnggota ?? 0 }}">0</h2>
                <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Total Anggota</p>
                <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #1ABC9C, #16A085); margin: 1rem auto; border-radius: 2px;"></div>
                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Guru: {{ $totalGuru ?? 0 }} | Siswa: {{ $totalSiswa ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    {{-- Card 2: Total Buku --}}
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
            onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(26, 188, 156, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
            onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
            
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(26, 188, 156, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(26, 188, 156, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                    <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(26, 188, 156, 0.3); animation: pulse 2s infinite;"></div>
                </div>
                <h2 style="font-size: 2.75rem; font-weight: 800; color: #1ABC9C; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $totalBuku ?? 0 }}">0</h2>
                <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Total Buku</p>
                <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #1ABC9C, #16A085); margin: 1rem auto; border-radius: 2px;"></div>
                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Koleksi tersedia</p>
            </div>
        </div>
    </div>
    
    {{-- Card 3: Peminjaman Aktif --}}
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
            onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(26, 188, 156, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
            onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
            
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(26, 188, 156, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(26, 188, 156, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                    <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(26, 188, 156, 0.3); animation: pulse 2s infinite;"></div>
                </div>
                <h2 style="font-size: 2.75rem; font-weight: 800; color: #1ABC9C; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $peminjamanAktif ?? 0 }}">0</h2>
                <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Peminjaman Aktif</p>
                <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #1ABC9C, #16A085); margin: 1rem auto; border-radius: 2px;"></div>
                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Buku sedang dipinjam</p>
            </div>
        </div>
    </div>
    
    {{-- Card 4: Buku Terlambat --}}
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
            onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(26, 188, 156, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
            onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(26, 188, 156, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
            
            <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(26, 188, 156, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(26, 188, 156, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                    <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(26, 188, 156, 0.3); animation: pulse 2s infinite;"></div>
                </div>
                <h2 style="font-size: 2.75rem; font-weight: 800; color: #1ABC9C; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $bukuTerlambat ?? 0 }}">0</h2>
                <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Buku Terlambat</p>
                <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #1ABC9C, #16A085); margin: 1rem auto; border-radius: 2px;"></div>
                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">⚠️ Melewati jatuh tempo</p>
            </div>
        </div>
    </div>
</div>

{{-- DENDA MONITORING SECTION (Kepala Sekolah) --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 12px 20px; border-radius: 10px; border-left: 4px solid #f59e0b; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.12);">
            <svg style="width: 24px; height: 24px; color: #d97706; margin-right: 12px;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h6 style="margin: 0; color: #92400e; font-weight: 700; font-size: 15px;">Monitoring Denda Perpustakaan</h6>
                <p style="margin: 0; color: #78350f; font-size: 11px;">Pantau pembayaran denda dari keterlambatan dan kerusakan buku</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0" style="border-radius: 1rem; background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left: 4px solid #ef4444; padding: 20px; box-shadow: 0 2px 12px rgba(239, 68, 68, 0.12);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p style="color: #991b1b; font-size: 0.8rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Belum Dibayar</p>
                    <h3 style="color: #dc2626; font-size: 1.75rem; font-weight: 800; margin: 8px 0;">Rp {{ number_format($totalDendaBelumDibayar ?? 0, 0, ',', '.') }}</h3>
                    <p style="color: #b91c1c; font-size: 0.7rem; margin: 0;">{{ $jumlahTransaksiBelumDibayar ?? 0 }} transaksi pending</p>
                </div>
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                    <svg style="width: 26px; height: 26px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0" style="border-radius: 1rem; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #10b981; padding: 20px; box-shadow: 0 2px 12px rgba(16, 185, 129, 0.12);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p style="color: #065f46; font-size: 0.8rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Sudah Dibayar</p>
                    <h3 style="color: #059669; font-size: 1.75rem; font-weight: 800; margin: 8px 0;">Rp {{ number_format($totalDendaSudahDibayar ?? 0, 0, ',', '.') }}</h3>
                    <p style="color: #047857; font-size: 0.7rem; margin: 0;">✅ Pendapatan terkumpul</p>
                </div>
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    <svg style="width: 26px; height: 26px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0" style="border-radius: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 20px; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.25);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p style="color: rgba(255,255,255,0.9); font-size: 0.8rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Keseluruhan</p>
                    <h3 style="color: white; font-size: 1.75rem; font-weight: 800; margin: 8px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Rp {{ number_format(($totalDendaBelumDibayar ?? 0) + ($totalDendaSudahDibayar ?? 0), 0, ',', '.') }}</h3>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.7rem; margin: 0;">💰 Akumulasi denda</p>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <svg style="width: 26px; height: 26px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modern Dashboard CSS --}}
<style>
    /* Modern Card Styling */
    .modern-card {
        border-radius: 1rem !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .modern-card .card-header {
        border-radius: 1rem 1rem 0 0 !important;
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

    /* Icon Box */
    .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* Smooth Transitions */
    * {
        transition: all 0.2s ease;
    }

    /* Responsive Typography */
    @media (max-width: 768px) {
        .modern-card h2 {
            font-size: 1.5rem;
        }
    }
</style>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Refresh Feather Icons - CRITICAL untuk menampilkan icon
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Re-replace feather icons after delay untuk memastikan semua icon muncul
        setTimeout(() => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }, 100);

        // MutationObserver untuk auto-replace icon saat DOM berubah
        const observer = new MutationObserver(() => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Enhanced Counter Animation with Easing
        const counters = document.querySelectorAll('.counter');

        // Easing function - easeOutQuart untuk efek smooth
        function easeOutQuart(x) {
            return 1 - Math.pow(1 - x, 4);
        }

        counters.forEach((counter, index) => {
            const target = parseInt(counter.getAttribute('data-target'));
            
            const duration = 1500; // 1.5 seconds
            const startTime = performance.now();

            const animateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutQuart(progress);
                const current = Math.floor(easedProgress * target);

                counter.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(animateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            // Start animation after a small delay
            setTimeout(() => {
                requestAnimationFrame(animateCounter);
            }, 300);
        });

        // 1. Grafik Peminjaman Per Bulan (Line Chart) - Modern Style
        const peminjamanCtx = document.getElementById('peminjamanChart').getContext('2d');
        const gradient = peminjamanCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.6)');
        gradient.addColorStop(1, 'rgba(118, 75, 162, 0.1)');

        const peminjamanChart = new Chart(peminjamanCtx, {
            type: 'line',
            data: {
                labels: {!! $bulanLabels !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! $peminjamanPerBulan !!},
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 6,
                    pointHoverRadius: 9,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointHoverBackgroundColor: 'rgb(118, 75, 162)',
                    pointHoverBorderColor: '#fff',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // 2. Grafik Status Eksemplar (Doughnut Chart) - Modern Style
        const statusCtx = document.getElementById('statusEksemplarChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'],
                datasets: [{
                    data: [
                        {{ $eksemplarTersedia }},
                        {{ $eksemplarDipinjam }},
                        {{ $eksemplarRusak }},
                        {{ $eksemplarHilang }}
                    ],
                    backgroundColor: [
                        '#38ef7d',  // Hijau modern
                        '#f5576c',  // Pink modern
                        '#fa709a',  // Merah soft
                        '#9e9e9e'   // Abu-abu
                    ],
                    borderWidth: 5,
                    borderColor: '#fff',
                    hoverOffset: 15,
                    hoverBorderWidth: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // 3. Grafik Top Kategori (Bar Chart) - Modern Style
        const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
        const kategoriChart = new Chart(kategoriCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($topKategori as $kat)
                        '{{ $kat->nama }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Buku',
                    data: [
                        @foreach($topKategori as $kat)
                            {{ $kat->buku_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(245, 87, 108, 0.8)',
                        'rgba(56, 239, 125, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(240, 147, 251, 0.8)'
                    ],
                    borderColor: [
                        'rgb(102, 126, 234)',
                        'rgb(245, 87, 108)',
                        'rgb(56, 239, 125)',
                        'rgb(79, 172, 254)',
                        'rgb(240, 147, 251)'
                    ],
                    borderWidth: 3,
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });

        // FINAL FEATHER REPLACE - Setelah semua chart di-render
        setTimeout(() => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }, 500);
    });

    // BACKUP: Replace feather on window load (absolute last resort)
    window.addEventListener('load', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
</div>
