# Projek Perpus - AI Coding Instructions

## Project Overview

Laravel 12 + Livewire 3 library management system (Sistem Perpustakaan) dengan RBAC untuk SD Muhammadiyah Karangwaru. Mengelola buku, anggota (guru/siswa), eksemplar fisik, dan transaksi peminjaman.

## Architecture Patterns

### Livewire Component Structure

-   **Full-page components**: Setiap Livewire component = 1 halaman lengkap (tidak ada controller tradisional)
-   **Layout system**: Gunakan `->layoutData(['title' => '...'])` untuk pass data ke layout utama
-   **Exception**: `LoginComponent` menggunakan layout terpisah: `->layout('components.layouts.login')`
-   **Component pattern**:
    -   `mount()` - Authentikasi & inisialisasi (set default tanggal, cek role)
    -   `render()` - Query data dengan eager loading, pass ke view
    -   `store()/update()/delete()` - CRUD operations dengan validasi Indonesia
    -   `resetInput()` - Clear form fields

### Database Schema & Relationships

**Primary keys kustom** (bukan Laravel default `id`):

-   `users.id_user` - Staff perpustakaan
-   `anggota.id_anggota` - Member perpustakaan (guru/siswa)
-   `kategori.id_kategori` - Kategori buku
-   `buku.id_buku` - Metadata buku
-   `eksemplar.id_eksemplar` - Copy fisik buku
-   `peminjaman.id_peminjaman` - Header transaksi
-   `detail_peminjaman.id_detail` - Detail per eksemplar
-   `log_aktivitas.id_logaktivitas` - Audit log (placeholder)

**Entity Relationship Diagram Flow**:

```
CATALOG MANAGEMENT (Koleksi Buku)
├── Kategori (1) → Buku (N)
│   ├── id_kategori (PK)
│   ├── nama
│   └── deskripsi
│
└── Buku (1) → Eksemplar (N)
    ├── id_buku (PK)
    ├── judul
    ├── no_panggil (DDC)
    └── kategori_id (FK)

    └── Eksemplar (copy fisik)
        ├── id_eksemplar (PK)
        ├── kode_eksemplar (UNIQUE)
        ├── lokasi_rak
        ├── status_eksemplar (ENUM)
        └── id_buku (FK)

TRANSACTION FLOW (Peminjaman)
├── Users (1) → Peminjaman (N)
│   ├── id_user (PK)
│   ├── nama_user
│   ├── role (pustakakan/kepala)
│   └── email
│
├── Anggota (1) → Peminjaman (N)
│   ├── id_anggota (PK)
│   ├── nama_anggota
│   ├── jenis_anggota (guru/siswa)
│   └── institusi
│
└── Peminjaman (1) → Detail_peminjaman (N)
    ├── id_peminjaman (PK)
    ├── kode_transaksi (UNIQUE)
    ├── tgl_pinjam
    ├── tgl_jatuh_tempo
    ├── status_buku (ENUM)
    ├── id_user (FK → users)
    └── id_anggota (FK → anggota)

    └── Detail_peminjaman (pivot table)
        ├── id_detail (PK)
        ├── id_peminjaman (FK)
        ├── id_eksemplar (FK)
        ├── tgl_kembali
        ├── kondisi_kembali (ENUM)
        └── denda_item

AUDIT LOG (Not Implemented)
└── Log_aktivitas
    ├── id_logaktivitas (PK)
    ├── id_user (FK)
    ├── aktivitas
    └── waktu
```

**Key Eloquent Relationships**:

```php
// Kategori → Buku
Kategori::hasMany(Buku, 'kategori_id', 'id_kategori')
Buku::belongsTo(Kategori, 'kategori_id', 'id_kategori')

// Buku → Eksemplar
Buku::hasMany(Eksemplar, 'id_buku', 'id_buku')
Eksemplar::belongsTo(Buku, 'id_buku', 'id_buku')

// Users/Anggota → Peminjaman
User::hasMany(Peminjaman, 'id_user')
Anggota::hasMany(Peminjaman, 'id_anggota')
Peminjaman::belongsTo(User, 'id_user')
Peminjaman::belongsTo(Anggota, 'id_anggota', 'id_anggota')

// Peminjaman → Detail_peminjaman ← Eksemplar
Peminjaman::hasMany(DetailPeminjaman, 'id_peminjaman', 'id_peminjaman')
Eksemplar::hasMany(DetailPeminjaman, 'id_eksemplar', 'id_eksemplar')
DetailPeminjaman::belongsTo(Peminjaman, 'id_peminjaman')
DetailPeminjaman::belongsTo(Eksemplar, 'id_eksemplar')
```

### Role-Based Access Control (RBAC)

**2 User Roles** di `users.role`:

-   **`pustakawan`**: Librarian - Full CRUD semua data, hanya bisa edit profil sendiri, tidak bisa hapus user lain
-   **`kepala`**: Kepala Sekolah - Read-only untuk monitoring, bisa tambah/hapus user

**RBAC Implementation Pattern**:

```php
// 1. Mount guard - redirect jika unauthorized
if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
    return redirect()->route('home');
}

// 2. Pass role flags ke view untuk conditional rendering
'isPustakawan' => Auth::user()->role === 'pustakawan',
'isKepala' => Auth::user()->role === 'kepala'

// 3. Di view - conditional buttons
@if($isPustakawan)
    <button wire:click="store">Simpan</button>
@endif
```

## Data Flow Architecture

### Catalog Management Flow (Kelola Koleksi)

1. **Input Kategori** → `KategoriSeeder` (10 kategori default)
2. **Input Buku** → Link ke `kategori_id` → Generate `no_panggil` (DDC)
3. **Input Eksemplar** → Link ke `id_buku` → Auto-generate `kode_eksemplar` (format: `{id_buku}-{sequence}`)
4. **Status Eksemplar** → Default: `tersedia`, dapat berubah ke: `dipinjam`, `hilang`, `rusak`

**Cascade Rules**:

-   Hapus Kategori → Hapus semua Buku terkait → Hapus semua Eksemplar
-   Hapus Buku → Hapus semua Eksemplar (tapi cek dulu: ada yang `dipinjam`?)
-   Eksemplar dengan status `dipinjam` → **PROTECTED** (tidak bisa dihapus)

### Transaction Management Flow (Peminjaman)

1. **Create Peminjaman** → Auto-generate `kode_transaksi` (PJM-YYYYMMDD-XXXX)
2. **Select Anggota** → Must be active member (guru/siswa)
3. **Select Eksemplar** → Filter: `status_eksemplar = 'tersedia'`
4. **Create Detail_peminjaman** → Pivot table: link `id_peminjaman` ↔ `id_eksemplar`
5. **Update Status** → Set `eksemplar.status_eksemplar = 'dipinjam'`
6. **Return Books** → Set `peminjaman.status_buku = 'kembali'` + restore `eksemplar.status_eksemplar = 'tersedia'`

**Business Rules**:

-   1 Peminjaman dapat meminjam **maksimal 3 eksemplar** (multiple books per transaction)
-   **Tidak boleh meminjam eksemplar dari buku yang sama** (harus beda judul, cek via `id_buku`)
-   1 Eksemplar hanya bisa dipinjam oleh **1 peminjaman aktif** (tidak bisa double booking)
-   Status sync antara `peminjaman.status_buku` dan `eksemplar.status_eksemplar` **harus konsisten**
-   **Peminjaman dengan status `dipinjam` (aktif) TIDAK BISA dihapus** - harus dikembalikan dulu via menu Pengembalian
-   Hanya peminjaman dengan status `kembali` yang bisa dihapus (untuk menghapus data historis)

### User & Authorization Flow

1. **Login** → Validasi email + password → Set session
2. **Role Check** → Mount guard di setiap component
3. **Conditional UI** → Pass `isPustakawan` & `isKepala` ke view
4. **Action Control**:
    - `pustakawan`: CRUD semua data, edit profil sendiri only
    - `kepala`: Read-only semua data, full user management (add/delete)

## Critical Workflows

### Transaction Pattern (Peminjaman Buku)

**5-Step Atomic Transaction**:

```php
DB::beginTransaction();
try {
    // 1. Generate kode unik: PJM-20251122-0001
    $kode = $this->generateKodeTransaksi();

    // 2. Create parent record
    $peminjaman = Peminjaman::create([
        'kode_transaksi' => $kode,
        'id_anggota' => $this->id_anggota,
        'jumlah_peminjaman' => count($selectedEksemplar),
        'status_buku' => 'dipinjam'
    ]);

    // 3. Create children records
    foreach ($selectedEksemplar as $id_eksemplar) {
        DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_eksemplar' => $id_eksemplar
        ]);

        // 4. Update eksemplar status (CRITICAL!)
        Eksemplar::where('id_eksemplar', $id_eksemplar)
            ->update(['status_eksemplar' => 'dipinjam']);
    }

    // 5. Commit transaction
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Peminjaman gagal', ['error' => $e->getMessage()]);
}
```

### Return Transaction Pattern (Pengembalian Buku)

**6-Step Return Process with Fine Calculation**:

```php
DB::beginTransaction();
try {
    // 1. Hitung denda keterlambatan
    $tgl_jatuh_tempo = Carbon::parse($peminjaman->tgl_jatuh_tempo);
    $tgl_kembali = Carbon::parse($this->tgl_kembali);
    $hari_terlambat = $tgl_kembali->gt($tgl_jatuh_tempo) ? $tgl_kembali->diffInDays($tgl_jatuh_tempo) : 0;
    $denda_keterlambatan = $hari_terlambat * $jumlah_buku * $tarif_per_hari;

    // 2. Update setiap detail peminjaman
    foreach ($this->detailItems as $id_detail => $item) {
        DetailPeminjaman::find($id_detail)->update([
            'tgl_kembali' => $this->tgl_kembali,
            'kondisi_kembali' => $item['kondisi_kembali'],
            'denda_item' => $item['denda_item'] // Denda rusak/hilang
        ]);

        // 3. Update status eksemplar berdasarkan kondisi
        $eksemplar = Eksemplar::find($detail->id_eksemplar);
        if ($item['kondisi_kembali'] === 'baik') {
            $eksemplar->status_eksemplar = 'tersedia';
        } elseif ($item['kondisi_kembali'] === 'rusak') {
            $eksemplar->status_eksemplar = 'rusak';
        } elseif ($item['kondisi_kembali'] === 'hilang') {
            $eksemplar->status_eksemplar = 'hilang';
        }
        $eksemplar->save();
    }

    // 4. Update status peminjaman
    $peminjaman->status_buku = 'kembali';
    $peminjaman->save();

    // 5. Total denda = keterlambatan + kerusakan
    $total_denda = $denda_keterlambatan + $denda_kerusakan;

    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
}
```

**Fine Calculation Rules**:

-   **Denda Keterlambatan**: Rp 1.000/hari/buku (configurable via `$tarif_denda_per_hari`)
-   **Denda Rusak**: Rp 50.000/buku (configurable via `$tarif_denda_rusak`)
-   **Denda Hilang**: Rp 100.000/buku (configurable via `$tarif_denda_hilang`)
-   Total = Denda Keterlambatan + Sum(Denda per Item)

### Status State Machine

**Eksemplar Status Flow**:

-   `tersedia` → `dipinjam` (via peminjaman) → `tersedia` (via return kondisi baik)
-   `tersedia` → `dipinjam` → `rusak` (via return kondisi rusak)
-   `tersedia` → `dipinjam` → `hilang` (via return kondisi hilang)
-   `tersedia` → `rusak`/`hilang` (manual update, tidak bisa jika `dipinjam`)

**Peminjaman Status**:

-   `dipinjam` → `kembali` (via PengembalianComponent)

**Business Rules**:

-   Eksemplar dengan status `dipinjam` TIDAK BISA diedit/dihapus manual
-   Harus kembalikan via `prosesKembalikan()` method di PengembalianComponent
-   Saat hapus peminjaman aktif → auto-restore status `tersedia`
-   Kondisi kembali default = 'baik', bisa diubah ke 'rusak' atau 'hilang'

### Kode Unik Generation Pattern

```php
// Format: [PREFIX]-[YYYYMMDD]-[SEQUENCE]
public function generateKodeTransaksi() {
    $date = date('Ymd');
    $last = Peminjaman::where('kode_transaksi', 'like', 'PJM-'.$date.'%')
        ->orderBy('kode_transaksi', 'desc')->first();

    $number = $last ? intval(substr($last->kode_transaksi, -4)) + 1 : 1;
    return 'PJM-'.$date.'-'.str_pad($number, 4, '0', STR_PAD_LEFT);
}

// Eksemplar: {id_buku}-{nomor} → "1-001", "1-002"
```

### Form Toggle Pattern (SPA-like UX)

```php
// Component
public $showForm = false;

// View
<button wire:click="$toggle('showForm')">Tambah</button>
@if($showForm)
    <form>...</form>
@endif
```

### Modal Detail Pattern (View Detail)

```php
// Component properties
public $showDetail = false;
public $detailPeminjaman = null;

// Method to open modal
public function viewDetail($id) {
    $this->detailPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
        ->find($id);
    $this->showDetail = true;
}

// Method to close modal
public function closeDetail() {
    $this->showDetail = false;
    $this->detailPeminjaman = null;
}

// View
@if($showDetail && $detailPeminjaman)
    <div class="modal">...</div>
@endif
```

### Deletion Protection Pattern (Peminjaman Aktif)

**CRITICAL**: Peminjaman dengan status `dipinjam` **TIDAK BOLEH** dihapus untuk menjaga integritas data dan audit trail.

```php
public function destroy($id) {
    DB::beginTransaction();
    try {
        $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);

        if ($peminjaman) {
            // PROTEKSI: Block deletion for active loans
            if ($peminjaman->status_buku == 'dipinjam') {
                session()->flash('error', 'Tidak bisa hapus peminjaman yang masih aktif! Lakukan pengembalian terlebih dahulu di menu Pengembalian.');
                return;
            }

            // Only allow deletion for returned loans (status = 'kembali')
            $peminjaman->delete();
            DB::commit();
            session()->flash('success', 'Peminjaman berhasil dihapus!');
        }
    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
    }
}
```

**UI Pattern**: Conditional button visibility

```blade
@if($data->status_buku === 'kembali')
    <button wire:click="destroy({{ $id }})">Hapus</button>
@else
    <button class="btn-secondary" disabled title="Kembalikan buku terlebih dahulu">
        <i data-feather="lock"></i> Terkunci
    </button>
@endif
```

### Livewire Events untuk Konfirmasi Delete

```php
// Component
public function confirmDelete($id) {
    $this->dispatch('confirm-delete', ['id' => $id]);
}

#[On('deleteUser')]
public function deleteNow($id) {
    User::find($id)->delete();
}

// View (JavaScript alert pattern)
<button onclick="confirm('Yakin?') || event.stopImmediatePropagation()"
    wire:click="destroy({{ $id }})">Hapus</button>
```

## Development Commands

### Setup (Laragon Windows)

```cmd
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install && npm run dev
```

### Seeding Data

-   **Users**: `hanafi@perpus.com` / `hanafi123` (pustakawan), `kepala@perpus.com` / `kepala123` (kepala)
-   **Anggota**: 5 guru, 15 siswa dari berbagai kelas
-   **Kategori**: 10 kategori (Fiksi, Non-Fiksi, Referensi, Sains, dll)
-   **Buku**: 50+ judul dengan no_panggil DDC (Dewey Decimal)
-   **Eksemplar**: 2-5 copy per buku, random status (80% tersedia)

### Running Application

```cmd
php artisan serve          # Backend server
npm run dev                # Vite dev server (Tailwind 4)
```

### Database Reset

```cmd
php artisan migrate:fresh --seed
```

## Conventions & Patterns

### Naming Conventions

-   **Database**: snake_case (`id_anggota`, `tgl_pinjam`, `status_eksemplar`)
-   **Models**: PascalCase (`Peminjaman`, `DetailPeminjaman`)
-   **Components**: `[Entity]Component.php` (e.g., `BukuComponent.php`)
-   **Views**: `[entity]-component.blade.php` (e.g., `buku-component.blade.php`)
-   **Routes**: Named routes (`route('peminjaman')`)

### Validation Pattern

**ALWAYS use Indonesian messages**:

```php
$this->validate([
    'judul' => 'required|max:255',
    'kategori_id' => 'required|exists:kategori,id_kategori'
], [
    'judul.required' => 'Judul buku harus diisi!',
    'judul.max' => 'Judul maksimal 255 karakter!',
    'kategori_id.required' => 'Kategori harus dipilih!',
    'kategori_id.exists' => 'Kategori tidak valid!'
]);
```

### Flash Messages

```php
session()->flash('success', 'Data berhasil disimpan!');
session()->flash('error', 'Gagal menyimpan data!');
session()->flash('info', 'Anda sudah login!');
session()->flash('warning', 'Perhatian!');
```

### Logging Strategy

Log **before and after** critical operations:

```php
Log::info('Store Peminjaman', ['id_anggota' => $this->id_anggota]);
// ... operation ...
Log::info('Peminjaman berhasil', ['kode' => $peminjaman->kode_transaksi]);
Log::error('Gagal', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
```

### Eager Loading (Anti N+1)

```php
// GOOD - Single query with relationships
Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
    ->paginate(10);

// BAD - N+1 queries
Peminjaman::all(); // Lalu di loop akses $p->anggota
```

### Pagination

```php
// Component
use WithPagination;
protected $paginationTheme = 'bootstrap';

// View
{{ $data->links() }}
```

## UI/UX Patterns

### Frontend Stack

-   **CSS Framework**: Bootstrap 4.5.2 (via CDN)
-   **Icons**: Feather Icons (via CDN)
-   **Build Tool**: Vite 7 + Tailwind 4 (dev dependencies, belum aktif digunakan)
-   **Custom CSS**: `public/asset/admin-dashboard.css`

### Layout Structure

```
app.blade.php (main layout)
├── sidebar.blade.php (fixed, 250px)
├── navigasi.blade.php (top bar)
└── {{ $slot }} (page content)
```

### Responsive Sidebar

-   Desktop: Fixed 250px sidebar
-   Mobile: Toggle sidebar dengan JavaScript `toggleSidebar()`
-   Auto-hide alerts setelah 5 detik

### Livewire Directives

-   `wire:model` - Two-way binding
-   `wire:model.live` - Real-time search/filter (debounce otomatis)
-   `wire:click` - Method call
-   `wire:click="$toggle('var')"` - Toggle boolean

### Feather Icons Refresh Pattern

**Problem**: Icons hilang setelah Livewire update (DOM morphing)
**Root Cause**: Livewire's DOM diffing converts `<svg>` back to `<i data-feather>` tags
**Solution**: Triple-layer defense dengan Alpine.js, Livewire hooks, dan MutationObserver

**Implementation Pattern**:

```blade
{{-- Layer 1: Alpine.js pada setiap elemen dengan icon --}}
<div class="btn-group" x-data x-init="$nextTick(() => feather.replace())">
    <button><i data-feather="edit-2"></i> Edit</button>
</div>

{{-- Layer 2: Global refresh function --}}
@assets
<script>
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            setTimeout(() => {
                feather.replace();
                console.log('✅ Icons refreshed');
            }, 150); // Delay untuk DOM completion
        }
    }
</script>
@endassets

{{-- Layer 3: Livewire hooks + MutationObserver --}}
@script
<script>
    refreshFeatherIcons();

    // Livewire lifecycle hooks
    Livewire.hook('element.init', () => refreshFeatherIcons());
    Livewire.hook('element.updated', () => refreshFeatherIcons());
    Livewire.hook('morph.updated', () => refreshFeatherIcons());
    Livewire.hook('commit', () => refreshFeatherIcons());

    // MutationObserver sebagai final backup
    const observer = new MutationObserver(() => refreshFeatherIcons());
    observer.observe(document.body, { childList: true, subtree: true });
</script>
@endscript
```

**Debugging**:

-   Buka browser console (F12)
-   Lihat log emoji: 🔵 element.init, 🟢 element.updated, 🟡 morph.updated, ✅ refreshed
-   Jika icons masih hilang: `php artisan view:clear` + hard refresh (Ctrl+Shift+R)

## Key Files

### Application Structure

```
app/
├── Livewire/           # Full-page components (no controllers)
│   ├── AnggotaComponent.php      # Member CRUD
│   ├── BukuComponent.php         # Book metadata CRUD
│   ├── EksemplarComponent.php    # Physical copy CRUD
│   ├── PeminjamanComponent.php   # Loan transactions (kompleks!)
│   ├── PengembalianComponent.php # Return transactions (denda calculation!)
│   ├── UserComponent.php         # Staff management
│   ├── HomeComponent.php         # Dashboard stats
│   └── LoginComponent.php        # Auth
└── Models/
    ├── Anggota.php          # $primaryKey = 'id_anggota'
    ├── Buku.php             # $primaryKey = 'id_buku'
    ├── Eksemplar.php        # $primaryKey = 'id_eksemplar'
    ├── Peminjaman.php       # $primaryKey = 'id_peminjaman'
    ├── DetailPeminjaman.php # $primaryKey = 'id_detail'
    ├── Kategori.php         # $primaryKey = 'id_kategori'
    └── LogAktivitas.php     # Placeholder (belum digunakan)

database/
├── migrations/2025_11_04_*   # Schema definitions
└── seeders/
    ├── UserSeeder.php        # 2 test accounts
    ├── AnggotaSeeder.php     # 20 members
    ├── KategoriSeeder.php    # 10 categories
    ├── BukuSeeder.php        # 50+ books
    └── EksemplarSeeder.php   # 2-5 copies/book

resources/views/
├── livewire/               # Component views
└── components/layouts/
    ├── app.blade.php       # Main layout (untuk semua halaman)
    ├── login.blade.php     # Auth layout (hanya login)
    ├── sidebar.blade.php   # Navigation menu
    └── navigasi.blade.php  # Top navbar
```

## Common Pitfalls & Solutions

### 1. Custom Primary Keys

**PROBLEM**: Laravel assumes `id` by default
**SOLUTION**:

```php
// Selalu deklarasikan di model
protected $primaryKey = 'id_buku';
```

### 2. Array Type Juggling

**PROBLEM**: Wire:model returns strings, DB expects integers
**SOLUTION**:

```php
$selectedEksemplar = array_map('intval', $this->selectedEksemplar);
```

### 3. Status Sync Bug

**PROBLEM**: Hapus peminjaman tapi eksemplar masih `dipinjam`
**SOLUTION**: Always check status before rollback

```php
if ($peminjaman->status_buku == 'dipinjam') {
    foreach ($peminjaman->detailPeminjaman as $detail) {
        Eksemplar::where('id_eksemplar', $detail->id_eksemplar)
            ->update(['status_eksemplar' => 'tersedia']);
    }
}
```

### 4. Protected Status Update

**PROBLEM**: User edit eksemplar yang sedang dipinjam
**SOLUTION**: Block di component

```php
if ($eksemplar->status_eksemplar === 'dipinjam' && $this->status_eksemplar !== 'dipinjam') {
    session()->flash('error', 'Buku sedang dipinjam! Kembalikan dulu via menu Peminjaman.');
    return;
}
```

### 5. Date Input Formatting

**PROBLEM**: Laravel/MySQL date format mismatch
**SOLUTION**:

```php
$this->tgl_pinjam = Carbon::now()->format('Y-m-d'); // HTML date input format
```

### 6. Pagination Reset on Search

**PROBLEM**: Search di page 3 tidak reset ke page 1
**SOLUTION**:

```php
public function updatingSearch() {
    $this->resetPage();
}
```

### 7. Livewire Events Naming

**PROBLEM**: Event listener tidak trigger
**SOLUTION**: Gunakan Attributes syntax Livewire v3

```php
#[On('deleteUser')]  // Bukan @listener
public function deleteNow($id) { ... }
```

## Dashboard Statistics

`HomeComponent` menghitung:

-   Total anggota (guru vs siswa)
-   Total buku (metadata)
-   Peminjaman aktif (count eksemplar dengan status `dipinjam`)
-   Buku terlambat (peminjaman `dipinjam` melewati `tgl_jatuh_tempo`)

## File Backup Pattern

Ada file `.backup5`, `.temp`, `.bak` di direktori - ini hasil iterasi development. **Ignore** file ini, gunakan yang tanpa suffix.
