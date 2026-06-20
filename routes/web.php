<?php

use App\Livewire\HomeComponent;
use App\Livewire\UserComponent;
use App\Livewire\AnggotaComponent;
use App\Livewire\BukuComponent;
use App\Livewire\EksemplarComponent;
use App\Livewire\PeminjamanComponent;
use App\Livewire\HistoryPeminjamanComponent;
use App\Livewire\PengembalianComponent;
use App\Livewire\HistoryPengembalianComponent;
use App\Livewire\KategoriComponent;
use App\Livewire\ProfilComponent;
use App\Livewire\LaporanComponent;
use App\Livewire\PengaturanComponent;
use App\Livewire\UnifiedLoginComponent;
use App\Livewire\VerifikasiPengajuanComponent;
use App\Livewire\AnggotaKatalogComponent;
use App\Livewire\AnggotaProfilComponent;
use Illuminate\Support\Facades\Route;

// Admin / Staff Routes
Route::get('/', function() {
    // Jika anggota yang login, redirect ke portal
    if (Auth::guard('anggota')->check()) {
        return redirect()->route('anggota.portal');
    }
    // Jika staff/admin yang login, ke dashboard
    if (Auth::check()) {
        return redirect()->route('home');
    }
    // Belum login, ke login
    return redirect()->route('login');
})->name('root');

Route::get('/home', HomeComponent::class)->middleware('auth')->name('home');
Route::get('/profil', ProfilComponent::class)->name('profil')->middleware('auth');
Route::get('/user', UserComponent::class)->name('user')->middleware('auth');
Route::get('/anggota', AnggotaComponent::class)->name('anggota')->middleware('auth');
Route::get('/kategori', KategoriComponent::class)->name('kategori')->middleware('auth');
Route::get('/buku', BukuComponent::class)->name('buku')->middleware('auth');
Route::get('/eksemplar', EksemplarComponent::class)->name('eksemplar')->middleware('auth');
Route::get('/peminjaman', PeminjamanComponent::class)->name('peminjaman')->middleware('auth');
Route::get('/history-peminjaman', HistoryPeminjamanComponent::class)->name('history-peminjaman')->middleware('auth');
Route::get('/history-peminjaman/export', [HistoryPeminjamanComponent::class, 'exportExcel'])->name('history-peminjaman.export')->middleware('auth');
Route::get('/pengembalian', PengembalianComponent::class)->name('pengembalian')->middleware('auth');
Route::get('/history-pengembalian', HistoryPengembalianComponent::class)->name('history-pengembalian')->middleware('auth');
Route::get('/laporan', LaporanComponent::class)->name('laporan')->middleware('auth');
Route::get('/pengaturan', PengaturanComponent::class)->name('pengaturan')->middleware('auth');
Route::get('/verifikasi-pengajuan', VerifikasiPengajuanComponent::class)->name('verifikasi-pengajuan')->middleware('auth');

Route::get('/anggota/{id}/kartu', function ($id) {
    $anggota = \App\Models\Anggota::findOrFail($id);
    return view('anggota.cetak-kartu', compact('anggota'));
})->name('cetakKartuAnggota')->middleware('auth');

Route::get('/login', UnifiedLoginComponent::class)->name('login');
Route::get('/logout', [UnifiedLoginComponent::class, 'keluar'])->name('logout');

// Portal Anggota Routes
Route::get('/anggota-login', fn() => redirect()->route('login'))->name('anggota.login');
Route::get('/anggota-logout', [UnifiedLoginComponent::class, 'keluar'])->name('anggota.logout');
Route::get('/portal', AnggotaKatalogComponent::class)->name('anggota.portal')->middleware('auth.anggota');
Route::get('/portal/profil', AnggotaProfilComponent::class)->name('anggota.profil')->middleware('auth.anggota');
