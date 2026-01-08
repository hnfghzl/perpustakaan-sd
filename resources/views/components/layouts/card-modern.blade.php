{{-- Modern Dashboard Cards - Enhanced Design --}}
<div style="padding: 2rem 0;">
    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Card 1: Total Anggota --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(239, 68, 68, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(239, 68, 68, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
                
                {{-- Decorative gradient background --}}
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(239, 68, 68, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                        <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        {{-- Pulse effect --}}
                        <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(239, 68, 68, 0.3); animation: pulse 2s infinite;"></div>
                    </div>
                    <h2 style="font-size: 2.75rem; font-weight: 800; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $totalAnggota ?? 0 }}">0</h2>
                    <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Total Anggota</p>
                    <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #ef4444, #dc2626); margin: 1rem auto; border-radius: 2px;"></div>
                    <a href="{{ route('anggota') }}" style="display: inline-flex; align-items: center; color: #ef4444; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;" 
                        onmouseover="this.style.color='#dc2626'; this.style.transform='translateX(5px)';" 
                        onmouseout="this.style.color='#ef4444'; this.style.transform='none';">
                        Lihat Detail 
                        <svg style="width: 14px; height: 14px; margin-left: 0.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Buku --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(16, 185, 129, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(16, 185, 129, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
                
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                        <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>
                        <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(16, 185, 129, 0.3); animation: pulse 2s infinite;"></div>
                    </div>
                    <h2 style="font-size: 2.75rem; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $totalBuku ?? 0 }}">0</h2>
                    <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Total Buku</p>
                    <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #10b981, #059669); margin: 1rem auto; border-radius: 2px;"></div>
                    <a href="{{ route('buku') }}" style="display: inline-flex; align-items: center; color: #10b981; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;" 
                        onmouseover="this.style.color='#059669'; this.style.transform='translateX(5px)';" 
                        onmouseout="this.style.color='#10b981'; this.style.transform='none';">
                        Lihat Detail 
                        <svg style="width: 14px; height: 14px; margin-left: 0.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 3: Transaksi --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(139, 92, 246, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(139, 92, 246, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(139, 92, 246, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
                
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                        <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(139, 92, 246, 0.3); animation: pulse 2s infinite;"></div>
                    </div>
                    <h2 style="font-size: 2.75rem; font-weight: 800; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $peminjamanAktif ?? 0 }}">0</h2>
                    <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Peminjaman Aktif</p>
                    <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #8b5cf6, #7c3aed); margin: 1rem auto; border-radius: 2px;"></div>
                    <a href="{{ route('peminjaman') }}" style="display: inline-flex; align-items: center; color: #8b5cf6; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;" 
                        onmouseover="this.style.color='#7c3aed'; this.style.transform='translateX(5px)';" 
                        onmouseout="this.style.color='#8b5cf6'; this.style.transform='none';">
                        Lihat Detail 
                        <svg style="width: 14px; height: 14px; margin-left: 0.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 4: Users --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(245, 158, 11, 0.15), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(245, 158, 11, 0.25), 0 10px 20px rgba(0,0,0,0.1)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(245, 158, 11, 0.15), 0 1px 3px rgba(0,0,0,0.05)';">
                
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body text-center p-4" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 85px; height: 85px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); margin-bottom: 1.5rem; box-shadow: 0 8px 30px rgba(245, 158, 11, 0.4), inset 0 -2px 10px rgba(0,0,0,0.1); position: relative;">
                        <svg style="width: 40px; height: 40px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                        <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(245, 158, 11, 0.3); animation: pulse 2s infinite;"></div>
                    </div>
                    <h2 style="font-size: 2.75rem; font-weight: 800; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.5rem 0; letter-spacing: -1px;" class="counter" data-target="{{ $totalAdmin ?? 0 }}">0</h2>
                    <p style="color: #475569; font-size: 0.95rem; font-weight: 600; margin: 0.5rem 0; letter-spacing: 0.5px;">Total Admin</p>
                    <div style="width: 40px; height: 3px; background: linear-gradient(90deg, #f59e0b, #d97706); margin: 1rem auto; border-radius: 2px;"></div>
                    <a href="{{ route('user') }}" style="display: inline-flex; align-items: center; color: #f59e0b; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;" 
                        onmouseover="this.style.color='#d97706'; this.style.transform='translateX(5px)';" 
                        onmouseout="this.style.color='#f59e0b'; this.style.transform='none';">
                        Lihat Detail 
                        <svg style="width: 14px; height: 14px; margin-left: 0.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- DENDA SECTION (Compact) --}}
    <div class="row g-3 mb-4">
        {{-- Header Section Denda --}}
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 10px 16px; border-radius: 10px; border-left: 3px solid #f59e0b; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.12);">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);">
                    <svg style="width: 20px; height: 20px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <h6 style="margin: 0; color: #92400e; font-weight: 700; font-size: 14px;">💰 Manajemen Denda</h6>
                    <p style="margin: 2px 0 0 0; color: #78350f; font-size: 11px;">Pantau pembayaran denda perpustakaan</p>
                </div>
            </div>
        </div>

        {{-- Card Denda Belum Dibayar --}}
        <div class="col-md-4">
            <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 12px rgba(239, 68, 68, 0.12); transition: all 0.3s ease; overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(239, 68, 68, 0.18)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 12px rgba(239, 68, 68, 0.12)';">
                
                <div class="card-body text-center p-3" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); margin-bottom: 0.75rem; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                        <svg style="width: 24px; height: 24px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 style="font-size: 1.5rem; font-weight: 800; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.25rem 0;">Rp {{ number_format($totalDendaBelumDibayar ?? 0, 0, ',', '.') }}</h4>
                    <p style="color: #64748b; font-size: 0.8rem; font-weight: 600; margin: 0.25rem 0;">Belum Dibayar</p>
                    <div style="margin-top: 8px; padding: 6px; background: #fef2f2; border-radius: 8px;">
                        <span style="font-size: 1.1rem; font-weight: 800; color: #dc2626;">{{ $jumlahTransaksiBelumDibayar ?? 0 }}</span>
                        <span style="font-size: 0.7rem; color: #991b1b; margin-left: 4px;">pending</span>
                    </div>
                    <a href="{{ route('pengembalian') }}" style="display: inline-flex; align-items: center; color: #ef4444; font-size: 0.75rem; font-weight: 600; text-decoration: none; margin-top: 8px;" 
                        onmouseover="this.style.color='#dc2626';" 
                        onmouseout="this.style.color='#ef4444';">
                        Kelola 
                        <svg style="width: 12px; height: 12px; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Card Denda Sudah Dibayar --}}
        <div class="col-md-4">
            <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 12px rgba(16, 185, 129, 0.12); transition: all 0.3s ease; overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.18)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 12px rgba(16, 185, 129, 0.12)';">
                
                <div class="card-body text-center p-3" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); margin-bottom: 0.75rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                        <svg style="width: 24px; height: 24px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 style="font-size: 1.5rem; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0.25rem 0;">Rp {{ number_format($totalDendaSudahDibayar ?? 0, 0, ',', '.') }}</h4>
                    <p style="color: #64748b; font-size: 0.8rem; font-weight: 600; margin: 0.25rem 0;">Sudah Dibayar</p>
                    <div style="margin-top: 8px; padding: 6px; background: #f0fdf4; border-radius: 8px;">
                        <span style="font-size: 0.7rem; color: #166534; font-weight: 700;">✅ PENDAPATAN</span>
                    </div>
                    <a href="{{ route('pengembalian') }}" style="display: inline-flex; align-items: center; color: #10b981; font-size: 0.75rem; font-weight: 600; text-decoration: none; margin-top: 8px;" 
                        onmouseover="this.style.color='#059669';" 
                        onmouseout="this.style.color='#10b981';">
                        Riwayat 
                        <svg style="width: 12px; height: 12px; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Card Total Denda --}}
        <div class="col-md-4">
            <div class="card border-0 h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 2px 12px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(245, 158, 11, 0.3)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 12px rgba(245, 158, 11, 0.2)';">
                
                <div class="card-body text-center p-3" style="position: relative; z-index: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: rgba(255, 255, 255, 0.25); margin-bottom: 0.75rem; backdrop-filter: blur(10px);">
                        <svg style="width: 24px; height: 24px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 style="font-size: 1.5rem; font-weight: 800; color: white; margin: 0.25rem 0; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Rp {{ number_format(($totalDendaBelumDibayar ?? 0) + ($totalDendaSudahDibayar ?? 0), 0, ',', '.') }}</h4>
                    <p style="color: rgba(255, 255, 255, 0.95); font-size: 0.8rem; font-weight: 600; margin: 0.25rem 0;">Total Keseluruhan</p>
                    <div style="margin-top: 8px; padding: 6px; background: rgba(255, 255, 255, 0.2); border-radius: 8px; backdrop-filter: blur(10px);">
                        <span style="font-size: 0.7rem; color: white; font-weight: 700;">💰 AKUMULASI</span>
                    </div>
                    <a href="{{ route('pengembalian') }}" style="display: inline-flex; align-items: center; color: white; font-size: 0.75rem; font-weight: 600; text-decoration: none; margin-top: 8px;" 
                        onmouseover="this.style.opacity='0.8';" 
                        onmouseout="this.style.opacity='1';">
                        Semua 
                        <svg style="width: 12px; height: 12px; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Info Section --}}
    <div class="row g-4">
        {{-- Date Card --}}
        <div class="col-md-6">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.12), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s ease; overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(59, 130, 246, 0.2)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(59, 130, 246, 0.12)';">
                
                <div style="position: absolute; top: -30%; right: -20%; width: 150%; height: 150%; background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body p-4" style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center">
                        <div style="flex-shrink: 0; width: 60px; height: 60px; border-radius: 1rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display: flex; align-items: center; justify-content: center; margin-right: 1.25rem; box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);">
                            <svg style="width: 30px; height: 30px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #94a3b8; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Hari Ini</p>
                            <h4 style="color: #1e293b; font-size: 1.25rem; font-weight: 800; margin: 0.4rem 0;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h4>
                            <p style="color: #64748b; font-size: 0.85rem; margin: 0; font-weight: 500;">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User Info Card --}}
        <div class="col-md-6">
            <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(16, 185, 129, 0.12), 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s ease; overflow: hidden; position: relative;" 
                onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(16, 185, 129, 0.2)';" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(16, 185, 129, 0.12)';">
                
                <div style="position: absolute; top: -30%; right: -20%; width: 150%; height: 150%; background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
                
                <div class="card-body p-4" style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center">
                        <div style="flex-shrink: 0; width: 60px; height: 60px; border-radius: 1rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; margin-right: 1.25rem; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);">
                            <svg style="width: 30px; height: 30px; color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #94a3b8; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Login Sebagai</p>
                            <h4 style="color: #1e293b; font-size: 1.25rem; font-weight: 800; margin: 0.4rem 0;">{{ Auth::user()->nama_user }}</h4>
                            <span style="display: inline-block; padding: 0.35rem 1rem; border-radius: 9999px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2);">✓ Pustakawan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Animations & Counter Script --}}
<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }
    }
</style>

{{-- Enhanced Counter Animation Script --}}
@once
<script>
    function animateCounter() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach((counter, index) => {
            const target = parseInt(counter.getAttribute('data-target')) || 0;
            
            // Reset to 0 before animating
            counter.textContent = '0';
            
            if (target === 0) {
                counter.textContent = '0';
                return;
            }
            
            // Use easing function for smooth animation
            const duration = 1500; // 1.5 seconds
            const startTime = performance.now();
            
            const easeOutQuart = (x) => {
                return 1 - Math.pow(1 - x, 4);
            };
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutQuart(progress);
                const current = Math.floor(easedProgress * target);
                
                counter.textContent = current;
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    counter.textContent = target;
                }
            };
            
            requestAnimationFrame(animate);
        });
    }
    
    // Initial load
    document.addEventListener('DOMContentLoaded', () => {
        animateCounter();
    });
    
    // Livewire hooks
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('element.init', () => {
            animateCounter();
        });
        
        Livewire.hook('element.updated', () => {
            animateCounter();
        });
        
        Livewire.hook('morph.updated', () => {
            animateCounter();
        });
        
        Livewire.hook('commit', ({ component, commit, respond }) => {
            setTimeout(animateCounter, 100);
        });
    }
    
    // Fallback: re-animate every 5 seconds (for testing)
    setInterval(() => {
        const counters = document.querySelectorAll('.counter');
        if (counters.length > 0) {
            const firstCounter = counters[0];
            const target = parseInt(firstCounter.getAttribute('data-target'));
            if (firstCounter.textContent !== String(target)) {
                animateCounter();
            }
        }
    }, 5000);
</script>
@endonce
