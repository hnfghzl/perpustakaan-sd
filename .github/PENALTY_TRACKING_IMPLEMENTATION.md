# Implementasi Sistem Tracking Denda (Penalty Tracking System)

## 📋 Overview

Sistem tracking denda telah ditambahkan untuk menyimpan informasi pembayaran denda secara permanen di database. Sebelumnya, denda hanya dihitung on-the-fly tanpa disimpan, sehingga tidak ada audit trail untuk keperluan akuntansi dan pelaporan.

## 🗄️ Database Changes

### Migration: `2025_12_16_141257_add_denda_columns_to_peminjaman_table.php`

**Kolom baru yang ditambahkan ke tabel `peminjaman`:**

```sql
-- Breakdown denda untuk audit trail
denda_keterlambatan DECIMAL(10,2) DEFAULT 0 -- Denda keterlambatan (Rp/hari/buku)
denda_kerusakan DECIMAL(10,2) DEFAULT 0     -- Total denda kerusakan/hilang buku

-- Status pembayaran denda
status_pembayaran ENUM('belum_dibayar', 'sudah_dibayar') DEFAULT 'belum_dibayar'
tgl_pembayaran DATE NULL                    -- Tanggal lunas pembayaran
```

**Note:** Kolom `denda_total` sudah ada di schema original tetapi tidak pernah digunakan. Sekarang sudah diaktifkan.

### Updated Model

**File:** `app/Models/Peminjaman.php`

```php
protected $fillable = [
    'id_user',
    'id_anggota',
    'tgl_pinjam',
    'tgl_jatuh_tempo',
    'denda_total',           // Existing - now activated
    'denda_keterlambatan',   // NEW
    'denda_kerusakan',       // NEW
    'status_pembayaran',     // NEW
    'tgl_pembayaran',        // NEW
    'jumlah_peminjaman',
    'status_buku',
    'kode_transaksi'
];
```

## 💼 Business Logic Changes

### PengembalianComponent.php

#### 1. Updated `prosesKembalikan()` Method

**Sebelumnya:**

-   Hitung denda → Tampilkan di modal → TIDAK disimpan ke database
-   Status peminjaman hanya diubah ke 'kembali'

**Sekarang:**

```php
// Update status peminjaman + SIMPAN DENDA
$peminjaman->status_buku = 'kembali';

// Simpan breakdown denda untuk audit trail
$peminjaman->denda_keterlambatan = $this->denda_keterlambatan;
$peminjaman->denda_kerusakan = $this->denda_kerusakan;
$peminjaman->denda_total = $this->total_denda;

// Set status pembayaran
if ($this->total_denda > 0) {
    $peminjaman->status_pembayaran = 'belum_dibayar';
    $peminjaman->tgl_pembayaran = null;
} else {
    // Jika tidak ada denda, set langsung sebagai lunas
    $peminjaman->status_pembayaran = 'sudah_dibayar';
    $peminjaman->tgl_pembayaran = Carbon::now();
}

$peminjaman->save();
```

#### 2. New Method: `markAsPaid($id)`

Method baru untuk menandai denda sebagai lunas:

```php
public function markAsPaid($id)
{
    $peminjaman = Peminjaman::find($id);

    if ($peminjaman->status_pembayaran === 'sudah_dibayar') {
        session()->flash('info', 'Denda sudah ditandai lunas sebelumnya.');
        return;
    }

    $peminjaman->status_pembayaran = 'sudah_dibayar';
    $peminjaman->tgl_pembayaran = Carbon::now();
    $peminjaman->save();

    session()->flash('success', 'Denda berhasil ditandai sudah dibayar!');
}
```

#### 3. Updated `render()` Method

**Sebelumnya:**

```php
->where('status_buku', 'dipinjam'); // Hanya tampilkan yang masih dipinjam
```

**Sekarang:**

```php
->whereIn('status_buku', ['dipinjam', 'kembali']); // Tampilkan dipinjam DAN kembali
```

Alasan: Agar buku yang sudah dikembalikan tetap muncul di list untuk tracking pembayaran denda.

#### 4. New Filter: `$filterPembayaran`

Filter baru untuk menyaring berdasarkan status pembayaran:

-   **`belum_dibayar`**: Hanya tampilkan yang belum lunas
-   **`sudah_dibayar`**: Hanya tampilkan yang sudah lunas

## 🎨 UI/UX Changes

### 1. Pengembalian View (`pengembalian-component.blade.php`)

#### Header Statistics

```blade
<h4>Pengembalian Buku
    <span>({{ $activeCount }} aktif
    @if($unpaidCount > 0)
        • <span style="color: #fef3c7;">{{ $unpaidCount }} belum lunas</span>
    @endif)
    </span>
</h4>
```

#### New Filter Section (3 columns)

```blade
<div class="col-md-4">Search</div>
<div class="col-md-4">Status Peminjaman (Aktif - Terlambat/Belum Terlambat)</div>
<div class="col-md-4">Status Pembayaran (Belum Lunas/Sudah Lunas)</div> <!-- NEW -->
```

#### Status Badges - Conditional Rendering

**Untuk buku yang masih dipinjam:**

```blade
<span>📚 Dipinjam</span>
```

**Untuk buku yang sudah dikembalikan:**

```blade
@if($data->denda_total > 0)
    @if($data->status_pembayaran === 'belum_dibayar')
        <span>💰 Belum Lunas</span> <!-- Red gradient -->
    @else
        <span>✅ Lunas</span>        <!-- Green gradient -->
    @endif
@else
    <span>✅ Dikembalikan</span>     <!-- Green gradient, no penalty -->
@endif
```

#### Action Buttons - Conditional Rendering

**Untuk buku yang masih dipinjam:**

```blade
<button wire:click="openReturnForm(...)">
    <i data-feather="check-circle"></i> Kembalikan
</button>
```

**Untuk buku yang sudah dikembalikan dengan denda belum lunas:**

```blade
<button wire:click="markAsPaid(...)"
        onclick="return confirm('Konfirmasi pembayaran denda Rp ...')">
    <i data-feather="dollar-sign"></i> Tandai Lunas
</button>
```

#### Penalty Display in List

Untuk buku yang sudah dikembalikan dan ada denda:

```blade
<div style="color: #dc2626; font-weight: 600;">
    <i data-feather="alert-circle"></i>
    Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
</div>
```

### 2. Peminjaman Detail Modal (`peminjaman-component.blade.php`)

#### New Section: Penalty Information

**Hanya tampil jika:**

-   `status_buku === 'kembali'` DAN
-   `denda_total > 0`

```blade
<div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
    <h6>Informasi Denda</h6>

    <div class="row">
        <div class="col-md-4">
            Denda Keterlambatan: Rp {{ denda_keterlambatan }}
        </div>
        <div class="col-md-4">
            Denda Kerusakan/Hilang: Rp {{ denda_kerusakan }}
        </div>
        <div class="col-md-4">
            Total Denda: Rp {{ denda_total }}
        </div>
    </div>

    <div>
        Status Pembayaran:
        @if($status_pembayaran === 'sudah_dibayar')
            ✅ Lunas ({{ tgl_pembayaran }})
        @else
            ⚠️ Belum Lunas
        @endif
    </div>
</div>
```

## 🔐 RBAC Implementation

**Role:** Hanya `pustakawan` yang bisa:

1. Proses pengembalian buku
2. Menandai denda sebagai lunas

**Role:** `kepala` hanya bisa:

-   Melihat data (read-only)
-   Tidak bisa edit/tandai lunas

## 📊 Calculation Rules

### Tarif Denda (Configurable)

```php
public $tarif_denda_per_hari = 1000;  // Rp 1.000/hari/buku
public $tarif_denda_rusak = 50000;    // Rp 50.000 untuk buku rusak
public $tarif_denda_hilang = 100000;  // Rp 100.000 untuk buku hilang
```

### Formula Perhitungan

**1. Denda Keterlambatan:**

```php
$hari_terlambat = (int) $tgl_jatuh_tempo->diffInDays($tgl_kembali);
$jumlah_buku = $detailPeminjaman->count();
$denda_keterlambatan = $hari_terlambat * $jumlah_buku * $tarif_denda_per_hari;
```

**2. Denda Kerusakan/Hilang:**

```php
foreach ($detailItems as $item) {
    if ($item['kondisi_kembali'] === 'rusak') {
        $denda_kerusakan += $tarif_denda_rusak;
    } elseif ($item['kondisi_kembali'] === 'hilang') {
        $denda_kerusakan += $tarif_denda_hilang;
    }
}
```

**3. Total Denda:**

```php
$total_denda = $denda_keterlambatan + $denda_kerusakan;
```

## 🔄 Workflow

### Scenario 1: Return with Late Penalty Only

1. User click "Kembalikan" di Pengembalian menu
2. Modal terbuka, sistem hitung denda keterlambatan otomatis
3. User pilih kondisi buku = "Baik"
4. User submit → Sistem save:
    - `denda_keterlambatan` = Calculated value
    - `denda_kerusakan` = 0
    - `denda_total` = denda_keterlambatan
    - `status_pembayaran` = 'belum_dibayar'
    - `tgl_pembayaran` = NULL
5. Buku muncul di list dengan badge "💰 Belum Lunas"

### Scenario 2: Return with Damage Penalty Only

1. User proses pengembalian tepat waktu (no late)
2. User pilih kondisi buku = "Rusak"
3. Sistem hitung: `denda_kerusakan` = Rp 50.000
4. User submit → Sistem save:
    - `denda_keterlambatan` = 0
    - `denda_kerusakan` = 50000
    - `denda_total` = 50000
    - `status_pembayaran` = 'belum_dibayar'
5. Badge "💰 Belum Lunas" + button "Tandai Lunas"

### Scenario 3: Return with Both Late + Damage Penalties

1. Late return + kondisi rusak
2. Sistem hitung keduanya
3. Save breakdown + total
4. Status = 'belum_dibayar'

### Scenario 4: On-Time Return, Good Condition

1. No late, kondisi baik
2. `denda_total` = 0
3. Sistem otomatis set:
    - `status_pembayaran` = 'sudah_dibayar'
    - `tgl_pembayaran` = Carbon::now()
4. Badge "✅ Dikembalikan" (no payment tracking needed)

### Scenario 5: Mark as Paid

1. Pustakawan cek list → ada badge "💰 Belum Lunas"
2. User klik "Tandai Lunas" → Konfirmasi muncul
3. Confirm → Sistem update:
    - `status_pembayaran` = 'sudah_dibayar'
    - `tgl_pembayaran` = Carbon::now()
4. Badge berubah ke "✅ Lunas"
5. Button "Tandai Lunas" hilang

## 📈 Future Enhancements

### Priority: Medium

-   [ ] Payment receipt printing (PDF)
-   [ ] Financial reports (daily/monthly penalty collection)
-   [ ] Payment history log (track who marked as paid)

### Priority: Low

-   [ ] Partial payment support (installments)
-   [ ] SMS/Email notification for unpaid penalties
-   [ ] Integration with school accounting system
-   [ ] Dashboard chart: Unpaid penalties over time

## 🧪 Testing Checklist

### Database Tests

-   [x] Migration runs successfully
-   [x] Columns added to `peminjaman` table
-   [x] Default values applied correctly
-   [x] Model fillable updated

### Business Logic Tests

-   [x] Return with no penalty → status_pembayaran = 'sudah_dibayar'
-   [x] Return with late penalty → denda_keterlambatan saved
-   [x] Return with damage penalty → denda_kerusakan saved
-   [x] Return with both → breakdown saved correctly
-   [x] Mark as paid → updates status & date

### UI Tests

-   [x] Payment status badges display correctly
-   [x] "Tandai Lunas" button only for unpaid penalties
-   [x] Payment filter works (Belum Lunas/Sudah Lunas)
-   [x] Penalty info displays in Peminjaman detail modal
-   [x] Header shows unpaid count

### RBAC Tests

-   [x] Only pustakawan can access Pengembalian
-   [x] Only pustakawan can mark as paid
-   [ ] Kepala cannot see payment action buttons

## 📝 Notes

1. **Existing `denda_total` column**: Already existed in original schema but was never used. Now activated and populated during return process.

2. **Backward compatibility**: Old records (before this update) will have:

    - `denda_total` = 0
    - `status_pembayaran` = 'belum_dibayar' (default)
    - These records won't show penalty info in UI

3. **Data integrity**: Once a book is returned and penalty is saved, it becomes immutable. The only allowed update is payment status change (via `markAsPaid`).

4. **Audit trail**: Full penalty breakdown is stored:

    - Late penalty amount
    - Damage/loss penalty amount
    - Total penalty
    - Payment status
    - Payment date (when paid)

5. **Performance**: No additional N+1 queries introduced. All data loaded via existing eager loading in `render()` method.

## 🚀 Deployment Steps

1. Backup database
2. Run migration: `php artisan migrate`
3. Clear view cache: `php artisan view:clear`
4. Test return process with sample data
5. Verify payment status tracking
6. Train staff on new workflow

## 📚 Documentation Updates

-   [x] Database schema documented
-   [x] Business logic documented
-   [x] UI changes documented
-   [x] Workflow scenarios documented
-   [ ] User manual updated (staff training)
-   [ ] API documentation (if applicable)

---

**Last Updated:** 2025-12-16  
**Version:** 1.0.0  
**Status:** ✅ Implemented & Tested
