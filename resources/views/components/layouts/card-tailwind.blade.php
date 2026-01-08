{{-- Modern Dashboard Pustakawan dengan Tailwind CSS --}}
<div class="space-y-8">
    {{-- SECTION 1: Summary Statistics Cards --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard Overview</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card 1: Total Anggota --}}
            <div class="group rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM15 20h-5v-2a3 3 0 015-3v3z"></path>
                        </svg>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2.763 5a4 4 0 00-3.706 2.255.75.75 0 00.868 1.112 2.5 2.5 0 013.75-2.376.75.75 0 00.888-1.001A4 4 0 009.237 12z"/>
                        </svg>
                        +12%
                    </span>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2 counter" data-target="{{ $x['totalAnggota'] ?? 0 }}">0</h3>
                <p class="text-white text-opacity-90 text-sm font-semibold mb-3">Total Anggota</p>
                
                <div class="flex gap-3 text-white text-opacity-90 text-xs font-medium pt-3 border-t border-white border-opacity-30">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                        <span>Guru: <span class="font-bold">{{ $x['totalGuru'] ?? 0 }}</span></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        <span>Siswa: <span class="font-bold">{{ $x['totalSiswa'] ?? 0 }}</span></span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Buku --}}
            <div class="group rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17c0 5.523 3.107 10 8 10s8-4.477 8-10c0-6.002-4.5-10.747-10-10.747z"></path>
                        </svg>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2.763 5a4 4 0 00-3.706 2.255.75.75 0 00.868 1.112 2.5 2.5 0 013.75-2.376.75.75 0 00.888-1.001A4 4 0 009.237 12z"/>
                        </svg>
                        Aktif
                    </span>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2 counter" data-target="{{ $x['totalBuku'] ?? 0 }}">0</h3>
                <p class="text-white text-opacity-90 text-sm font-semibold mb-3">Total Buku</p>
                
                <div class="flex items-center gap-2 text-white text-opacity-90 text-xs font-medium pt-3 border-t border-white border-opacity-30">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Koleksi tersedia di perpustakaan</span>
                </div>
            </div>

            {{-- Card 3: Peminjaman Aktif --}}
            <div class="group rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-2.763 5a4 4 0 00-3.706 2.255.75.75 0 00.868 1.112 2.5 2.5 0 013.75-2.376.75.75 0 00.888-1.001A4 4 0 009.237 12z"/>
                        </svg>
                        Live
                    </span>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2 counter" data-target="{{ $x['peminjamanAktif'] ?? 0 }}">0</h3>
                <p class="text-white text-opacity-90 text-sm font-semibold mb-3">Peminjaman Aktif</p>
                
                <div class="flex items-center gap-2 text-white text-opacity-90 text-xs font-medium pt-3 border-t border-white border-opacity-30">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                    </svg>
                    <span>Eksemplar sedang dipinjam anggota</span>
                </div>
            </div>

            {{-- Card 4: Buku Terlambat --}}
            <div class="group rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 005.11 7.23m8.367 10.66A6 6 0 014.34 5.4m12.32 1.27A6 6 0 1010.34 19.82m0-15.64a6 6 0 110 12.28" clip-rule="evenodd"></path>
                        </svg>
                        Alert
                    </span>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2 counter" data-target="{{ $x['bukuTerlambat'] ?? 0 }}">0</h3>
                <p class="text-white text-opacity-90 text-sm font-semibold mb-3">Buku Terlambat</p>
                
                <div class="flex items-center gap-2 text-white text-opacity-90 text-xs font-medium pt-3 border-t border-white border-opacity-30">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Perlu tindakan segera</span>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: System Information Cards --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Sistem</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Admin Info Card --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-14 w-14 rounded-xl" style="background: rgba(26, 188, 156, 0.1);">
                            <svg class="h-8 w-8" style="color: #1ABC9C;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Admin</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $x['totalAdmin'] ?? 0 }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Pengguna sistem aktif</p>
                    </div>
                </div>
            </div>

            {{-- Date Info Card --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-14 w-14 rounded-xl" style="background: rgba(26, 188, 156, 0.1);">
                            <svg class="h-8 w-8" style="color: #1ABC9C;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 mb-1">Hari Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                    </div>
                </div>
            </div>

            {{-- User Info Card --}}
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-14 w-14 rounded-xl" style="background: rgba(26, 188, 156, 0.1);">
                            <svg class="h-8 w-8" style="color: #1ABC9C;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-2m0 0H9m3 0h2m-6 4a4 4 0 11-8 0 4 4 0 018 0zm-3-8a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-500 mb-1">Login Sebagai</p>
                        <h3 class="text-lg font-bold text-gray-900 truncate">{{ Auth::user()->nama_user }}</h3>
                        <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Pustakawan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Counter Animation Script --}}
@once
<script>
    function animateCounter() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // milliseconds per increment

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const increment = target / speed;
            let current = 0;

            const updateCount = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    setTimeout(updateCount, 10);
                } else {
                    counter.textContent = target;
                }
            };

            updateCount();
        });
    }

    // Run animation when page loads
    document.addEventListener('DOMContentLoaded', animateCounter);
    
    // Also run on Livewire updates
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('element.updated', animateCounter);
        Livewire.hook('morph.updated', animateCounter);
    }
</script>
@endonce
