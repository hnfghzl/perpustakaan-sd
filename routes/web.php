<?php

use App\Livewire\HomeComponent;
use App\Livewire\LoginComponent;
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
use Illuminate\Support\Facades\Route;

Route::get('/', HomeComponent::class)->middleware('auth')->name('home');
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

Route::get('/login', LoginComponent::class)->name('login');
Route::get('/logout', [LoginComponent::class, 'keluar'])->name('logout');
