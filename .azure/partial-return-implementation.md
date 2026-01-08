# Implementasi Pengembalian Parsial (Per Buku)

## 📋 Overview

Fitur pengembalian parsial memungkinkan pustakawan mengembalikan buku secara satuan (1, 2, atau 3 buku) dari satu transaksi peminjaman, tidak harus sekaligus semua.

## 🔧 Perubahan Backend (PengembalianComponent.php)

### 1. Property Baru

```php
public $selectedEksemplar = []; // Track checkbox yang dicentang
```

### 2. Method `openReturnForm($id)` - MODIFIED

-   Inisialisasi `$selectedEksemplar` dengan semua id_detail (default: semua tercentang)
-   Filter hanya tampilkan detail yang belum dikembalikan (`!$detail->tgl_kembali`)

```php
$this->selectedEksemplar = $this->selectedPeminjaman->detailPeminjaman
    ->filter(fn($d) => !$d->tgl_kembali)
    ->pluck('id_detail')
    ->toArray();
```

### 3. Method `closeReturnForm()` - MODIFIED

-   Reset `$selectedEksemplar = []` saat tutup form

### 4. Method `hitungDenda()` - MODIFIED

-   Hanya hitung denda untuk buku yang dicentang
-   Skip jika `!in_array($id_detail, $this->selectedEksemplar)`
-   Denda keterlambatan = `hari_terlambat × count($selectedEksemplar) × 1000`

### 5. Method `updatedSelectedEksemplar()` - NEW

-   Listener otomatis saat checkbox berubah
-   Panggil `hitungDenda()` untuk recalculate

### 6. Method `prosesKembalikan()` - MODIFIED (CRITICAL!)

**Validasi:**

```php
if (empty($this->selectedEksemplar)) {
    session()->flash('error', 'Pilih minimal 1 buku untuk dikembalikan!');
    return;
}
```

**Loop hanya buku yang dicentang:**

```php
foreach ($this->selectedEksemplar as $id_detail) {
    // Update DetailPeminjaman (tgl_kembali, kondisi, denda)
    // Update status Eksemplar (tersedia/rusak/hilang)
}
```

**Cek status peminjaman:**

```php
$totalBuku = $peminjaman->detailPeminjaman->count();
$bukuDikembalikan = $peminjaman->detailPeminjaman->whereNotNull('tgl_kembali')->count();

if ($bukuDikembalikan >= $totalBuku) {
    $peminjaman->status_buku = 'kembali'; // Semua sudah dikembalikan
} else {
    $peminjaman->status_buku = 'dipinjam'; // Masih ada yang belum
}
```

**Akumulasi denda (untuk multiple partial returns):**

```php
$peminjaman->denda_keterlambatan = ($peminjaman->denda_keterlambatan ?? 0) + $this->denda_keterlambatan;
$peminjaman->denda_kerusakan = ($peminjaman->denda_kerusakan ?? 0) + $this->denda_kerusakan;
$peminjaman->denda_total = $peminjaman->denda_keterlambatan + $peminjaman->denda_kerusakan;
```

## 🎨 Perubahan Frontend (pengembalian-modern.blade.php)

### 1. Header dengan Counter & Buttons

```blade
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h6>
        Daftar Buku yang Dikembalikan
        (<span id="selectedCount">{{ count($selectedEksemplar) }}</span>/{{ $selectedPeminjaman->detailPeminjaman->count() }})
    </h6>
    <div>
        <button wire:click="$set('selectedEksemplar', {{ ids... }})">Pilih Semua</button>
        <button wire:click="$set('selectedEksemplar', [])">Batal Pilih</button>
    </div>
</div>
```

### 2. Checkbox per Item

```blade
@foreach($selectedPeminjaman->detailPeminjaman as $detail)
    @php $isChecked = in_array($detail->id_detail, $selectedEksemplar); @endphp
    <div style="border: 2px solid {{ $isChecked ? '#3b82f6' : '#e5e7eb' }};">
        <input type="checkbox"
               wire:model.live="selectedEksemplar"
               value="{{ $detail->id_detail }}"
               style="width: 20px; height: 20px; accent-color: #3b82f6;">
        ...
    </div>
@endforeach
```

**Visual Feedback:**

-   Border biru (#3b82f6) jika tercentang
-   Border abu (#e5e7eb) jika tidak tercentang

### 3. Update Ringkasan Denda

```blade
{{ $hari }} hari × {{ count($selectedEksemplar) }} buku dipilih × Rp 1.000
```

### 4. Warning jika Tidak Ada yang Dipilih

```blade
@if(count($selectedEksemplar) === 0)
<div style="background: #fef2f2; border: 2px solid #ef4444;">
    <i data-feather="alert-triangle"></i>
    Tidak Ada Buku yang Dipilih
    <div>Silakan pilih minimal 1 buku untuk dikembalikan...</div>
</div>
@endif
```

## 📊 Business Logic Flow

### Skenario 1: Return Semua Buku Sekaligus

1. User buka form pengembalian → Semua checkbox tercentang (default)
2. Set tanggal kembali, pilih kondisi per buku
3. Klik "Proses Pengembalian"
4. System: Update semua detail, status peminjaman → **'kembali'**

### Skenario 2: Return Parsial (1 dari 3 buku)

1. User buka form → 3 checkbox tercentang
2. User UNCHECK 2 buku, tinggal 1 buku dicentang
3. Denda recalculate otomatis (via `wire:model.live`)
4. Klik "Proses Pengembalian"
5. System:
    - Update hanya 1 detail yang dicentang
    - Status peminjaman tetap **'dipinjam'** (2 buku belum kembali)
    - Denda di-akumulasi ke `denda_keterlambatan` peminjaman

### Skenario 3: Return Bertahap (3 kali return untuk 3 buku)

**Return #1:**

-   User kembalikan buku A → Status: dipinjam, denda: Rp 3.000

**Return #2:**

-   User kembalikan buku B → Status: dipinjam, denda: Rp 3.000 + Rp 3.000 = Rp 6.000

**Return #3:**

-   User kembalikan buku C → Status: **kembali**, denda: Rp 6.000 + Rp 3.000 = Rp 9.000

## 🔒 Data Integrity Rules

### 1. Checkbox Validation

-   Minimal 1 checkbox harus tercentang
-   Validasi di backend (`prosesKembalikan()`)
-   Flash error jika tidak ada yang dipilih

### 2. Status Sync

-   `DetailPeminjaman.tgl_kembali` → NOT NULL (sudah dikembalikan)
-   `Eksemplar.status_eksemplar` → 'tersedia'/'rusak'/'hilang' (sesuai kondisi)
-   `Peminjaman.status_buku` → 'dipinjam' (partial) atau 'kembali' (complete)

### 3. Denda Accumulation

-   Setiap partial return menambah denda ke peminjaman
-   Formula: `old_denda + new_denda`
-   Breakdown: `denda_keterlambatan`, `denda_kerusakan`, `denda_total`

### 4. Filter Displayed Items

-   Hanya tampilkan detail yang belum dikembalikan (`!$detail->tgl_kembali`)
-   Jika semua sudah dikembalikan → Form kosong (tidak ada item)

## 🧪 Testing Checklist

### Test Case 1: Return Semua Buku

-   [x] Borrow 3 books
-   [ ] Open return form → All checkboxes checked
-   [ ] Set return date
-   [ ] Click "Proses Pengembalian"
-   [ ] Verify: Status = 'kembali', all eksemplar = 'tersedia'

### Test Case 2: Return 1 dari 3

-   [x] Borrow 3 books
-   [ ] Open return form → Uncheck 2 books
-   [ ] Verify: Denda recalculates (1 book × days)
-   [ ] Click "Proses Pengembalian"
-   [ ] Verify: Status = 'dipinjam', 1 eksemplar = 'tersedia', 2 eksemplar = 'dipinjam'

### Test Case 3: Return Bertahap 3x

-   [x] Borrow 3 books
-   [ ] Return book 1 → Verify status 'dipinjam'
-   [ ] Return book 2 → Verify status 'dipinjam', denda akumulasi
-   [ ] Return book 3 → Verify status 'kembali', total denda benar

### Test Case 4: Return dengan Kondisi Berbeda

-   [x] Borrow 3 books
-   [ ] Return book 1: kondisi 'baik' → Verify eksemplar = 'tersedia'
-   [ ] Return book 2: kondisi 'rusak' → Verify eksemplar = 'rusak', denda +50k
-   [ ] Return book 3: kondisi 'hilang' → Verify eksemplar = 'hilang', denda +100k

### Test Case 5: Validation

-   [ ] Open return form → Uncheck all
-   [ ] Click "Proses Pengembalian"
-   [ ] Verify: Error flash "Pilih minimal 1 buku..."

### Test Case 6: UI Feedback

-   [ ] Check/uncheck boxes → Verify border color changes (blue/gray)
-   [ ] Verify counter updates: "2/3" format
-   [ ] Click "Pilih Semua" → All checked
-   [ ] Click "Batal Pilih" → All unchecked

## 🎯 Key Features

✅ **Checkbox Selection** - Pilih buku mana yang mau dikembalikan
✅ **Real-time Denda Calculation** - Denda update otomatis saat checkbox change
✅ **Smart Status Detection** - Otomatis set status 'dipinjam' vs 'kembali'
✅ **Accumulative Fines** - Denda terakumulasi untuk multiple returns
✅ **Visual Feedback** - Border biru untuk selected items
✅ **Select All/None Buttons** - Kemudahan pilih semua atau batal
✅ **Counter Display** - "2/3 buku dipilih"
✅ **Warning Alert** - Notifikasi jika tidak ada yang dipilih
✅ **Filter Returned Items** - Tidak tampilkan buku yang sudah dikembalikan

## 📝 Notes

-   Feather Icons refresh otomatis via Livewire hooks (debounced 150ms)
-   Menggunakan `wire:model.live` untuk instant update
-   Transaction safety dengan `DB::beginTransaction()` dan `DB::commit()`
-   Log audit di `storage/logs/laravel.log` untuk setiap pengembalian
-   Email notification (optional, jika anggota punya email)

## 🚀 Deployment

1. Pastikan sudah migrate database
2. Clear cache: `php artisan cache:clear`
3. Clear view: `php artisan view:clear`
4. Test di browser dengan data seeder
5. Monitor `storage/logs/laravel.log` untuk errors
