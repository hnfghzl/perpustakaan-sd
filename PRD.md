# Product Requirements Document (PRD)
# Sistem Informasi Manajemen Perpustakaan Sekolah Dasar (SIMPS-SD)

---

**Versi Dokumen:** 1.0  
**Tanggal:** 6 Juni 2026  
**Status:** Draft  
**Dibuat oleh:** Tim Pengembang  
**Platform:** Web Application (Laravel 12 + Livewire 3)

---

## 1. Ringkasan Eksekutif

### 1.1 Latar Belakang

Perpustakaan sekolah dasar memiliki peran penting dalam mendukung kegiatan belajar mengajar. Namun, pengelolaan perpustakaan secara manual (buku catatan fisik, kartu peminjaman) rentan terhadap kesalahan, data hilang, dan ketidakefisienan operasional. Sistem Informasi Manajemen Perpustakaan Sekolah Dasar (SIMPS-SD) hadir sebagai solusi digital yang menggantikan proses manual tersebut.

### 1.2 Tujuan Produk

SIMPS-SD adalah aplikasi web berbasis Laravel 12 + Livewire 3 yang dirancang untuk:

- Mendigitalisasi seluruh proses operasional perpustakaan sekolah dasar
- Mempermudah manajemen koleksi buku, keanggotaan, dan transaksi peminjaman/pengembalian
- Menghadirkan portal mandiri bagi siswa dan guru untuk mengajukan peminjaman secara online
- Menyediakan laporan dan analisis berbasis data untuk pengambilan keputusan kepala sekolah

### 1.3 Sasaran Pengguna

| Peran | Deskripsi |
|---|---|
| **Kepala Sekolah** | Memonitor statistik dan laporan manajerial perpustakaan |
| **Pustakawan** | Mengelola koleksi, anggota, transaksi, dan pengembalian buku |
| **Siswa** | Mengakses katalog dan mengajukan peminjaman buku secara mandiri |
| **Guru** | Mengakses katalog dan mengajukan peminjaman buku secara mandiri |

---

## 2. Ruang Lingkup Sistem

### 2.1 Dalam Ruang Lingkup (In Scope)

- ✅ Manajemen data anggota (siswa & guru)
- ✅ Manajemen koleksi buku dan eksemplar
- ✅ Transaksi peminjaman dan pengembalian buku
- ✅ Sistem pengajuan peminjaman mandiri oleh anggota (portal anggota)
- ✅ Verifikasi dan persetujuan pengajuan oleh pustakawan/kepala
- ✅ Perhitungan denda otomatis (keterlambatan, kerusakan, kehilangan)
- ✅ Notifikasi WhatsApp otomatis
- ✅ Laporan dan analisis manajerial
- ✅ Manajemen pengguna admin (pustakawan)
- ✅ Pengaturan sistem yang dapat dikonfigurasi
- ✅ Log aktivitas sistem

### 2.2 Di Luar Ruang Lingkup (Out of Scope)

- ❌ Aplikasi mobile native (Android/iOS)
- ❌ Integrasi dengan sistem akademik sekolah (rapor, absensi)
- ❌ Manajemen keuangan perpustakaan secara penuh
- ❌ Sistem reservasi buku online
- ❌ Katalog online publik tanpa login

---

## 3. Aktor dan Peran Sistem

### 3.1 Aktor Admin (Staf Perpustakaan)

#### 3.1.1 Kepala Sekolah (`role: kepala`)

**Hak Akses:**
- Dashboard statistik real-time
- Laporan manajerial (peminjaman, keanggotaan, inventaris, analisis kebutuhan)
- Menyetujui atau menolak pengajuan peminjaman dari anggota
- Melihat semua data tetapi tidak dapat melakukan pengembalian buku

#### 3.1.2 Pustakawan (`role: pustakawan`)

**Hak Akses:**
- Semua fitur kepala sekolah
- Manajemen lengkap koleksi buku dan eksemplar
- Manajemen data anggota
- Transaksi peminjaman langsung (tanpa proses pengajuan)
- Proses pengembalian buku dan perhitungan denda
- Manajemen pengguna admin
- Konfigurasi pengaturan sistem

### 3.2 Aktor Anggota (Portal Anggota)

#### 3.2.1 Siswa (`jenis_anggota: siswa`)
- Login ke portal anggota
- Browsing katalog buku
- Mengajukan peminjaman buku (maks. 3 buku per transaksi)
- Melihat riwayat peminjaman dan status pengajuan

#### 3.2.2 Guru (`jenis_anggota: guru`)
- Sama dengan hak akses siswa

---

## 4. Fitur dan Kebutuhan Fungsional

### 4.1 Modul Autentikasi

#### FR-01: Login Terpadu (Unified Login)
- Sistem menyediakan satu halaman login untuk semua pengguna
- Sistem mendeteksi secara otomatis apakah pengguna adalah admin (users table) atau anggota (anggota table) berdasarkan kredensial yang dimasukkan
- Admin diarahkan ke dashboard admin setelah login
- Anggota diarahkan ke portal anggota setelah login

#### FR-02: Manajemen Sesi
- Sesi login tersimpan dengan mekanisme remember token
- Logout membersihkan semua sesi aktif

---

### 4.2 Modul Dashboard Admin

#### FR-03: Dashboard Statistik Real-Time

Menampilkan kartu statistik berikut:
- Total anggota (breakdown: guru & siswa)
- Total judul buku dalam koleksi
- Jumlah transaksi peminjaman aktif
- Jumlah buku yang melewati jatuh tempo (terlambat)
- Total denda yang belum dibayar (dalam Rupiah)
- Total denda yang sudah dibayar

#### FR-04: Grafik Dashboard

- **Grafik Tren Peminjaman:** Line chart peminjaman per bulan (6 bulan terakhir)
- **Grafik Status Eksemplar:** Doughnut chart komposisi status (tersedia, dipinjam, rusak, hilang)
- **Grafik Top 5 Kategori:** Bar chart kategori buku dengan koleksi terbanyak

---

### 4.3 Modul Manajemen Koleksi Buku

#### FR-05: Manajemen Data Buku (Master Buku)

Atribut buku yang dikelola:
- Judul buku
- Pengarang
- Penerbit
- Tahun terbit
- ISBN
- No. Panggil (call number)
- Kategori/klasifikasi buku
- Sampul/cover buku (opsional)

Operasi CRUD:
- Tambah buku baru
- Edit informasi buku
- Hapus buku (dengan validasi: tidak boleh hapus jika masih ada eksemplar terkait)
- Pencarian buku (berdasarkan judul, pengarang, ISBN, no. panggil)

#### FR-06: Manajemen Eksemplar

Setiap judul buku dapat memiliki beberapa eksemplar fisik.

Atribut eksemplar:
- Kode eksemplar (unik, untuk pelacakan fisik)
- Lokasi rak penyimpanan
- Kondisi/status eksemplar: `tersedia`, `dipinjam`, `rusak`, `hilang`

Aturan bisnis:
- Status eksemplar berubah otomatis saat transaksi peminjaman/pengembalian
- Eksemplar dengan status `dipinjam` tidak dapat dipinjam kembali
- Eksemplar dengan status `rusak` atau `hilang` tidak tersedia untuk dipinjam

#### FR-07: Manajemen Kategori Buku

- CRUD untuk kategori/klasifikasi buku
- Kategori digunakan sebagai filter pada katalog

---

### 4.4 Modul Manajemen Anggota

#### FR-08: Data Anggota

Atribut anggota:
- NIS (Nomor Induk Siswa) / NIP (untuk guru)
- Nama lengkap
- Jenis anggota: `guru` atau `siswa`
- Kelas (khusus siswa)
- Jenis kelamin
- Tanggal lahir
- Alamat
- Institusi/sekolah
- Email
- No. HP (digunakan untuk notifikasi WhatsApp)
- Masa berlaku keanggotaan
- Tanggal registrasi

Operasi:
- Tambah anggota baru
- Edit data anggota
- Hapus anggota (dengan validasi: tidak boleh hapus jika memiliki peminjaman aktif)
- Pencarian anggota (berdasarkan nama, NIS, jenis anggota, institusi)

#### FR-09: Autentikasi Anggota

- Anggota memiliki password terpisah dari sistem admin
- Anggota dapat login ke portal anggota menggunakan NIS/email + password
- Anggota dapat mengubah profil dan password

---

### 4.5 Modul Transaksi Peminjaman

#### FR-10: Peminjaman Langsung oleh Pustakawan

Alur peminjaman:
1. Pustakawan memilih anggota dari daftar (dengan fitur pencarian)
2. Pustakawan memilih eksemplar buku yang tersedia
3. Sistem otomatis menghitung tanggal jatuh tempo (berdasarkan pengaturan durasi)
4. Sistem memvalidasi:
   - Anggota tidak boleh memiliki peminjaman aktif sebelumnya
   - Jumlah buku tidak melebihi batas maksimum per transaksi
   - Tidak boleh meminjam eksemplar dari judul buku yang sama dalam satu transaksi
   - Durasi tidak melebihi maksimum yang dikonfigurasi
5. Sistem membuat kode transaksi otomatis (format: `PJM-YYYYMMDD-XXXX`)
6. Status eksemplar yang dipinjam berubah dari `tersedia` menjadi `dipinjam`
7. Sistem menampilkan struk/bukti peminjaman yang dapat dicetak
8. Notifikasi WhatsApp dikirim ke anggota setelah struk ditutup

#### FR-11: Pengajuan Peminjaman oleh Anggota (Portal Anggota)

Alur pengajuan mandiri:
1. Anggota login ke portal anggota
2. Anggota browsing katalog dan memilih eksemplar (maks. 3)
3. Anggota mengajukan peminjaman → status: `menunggu`
4. **Eksemplar TIDAK langsung dikunci** pada tahap ini (menghindari "race condition")
5. Anggota menerima bukti pengajuan dengan kode transaksi

Validasi:
- Tidak boleh ada peminjaman aktif (status: `dipinjam`)
- Tidak boleh ada pengajuan yang sedang menunggu verifikasi
- Maksimum 3 eksemplar per pengajuan

#### FR-12: Verifikasi Pengajuan oleh Pustakawan/Kepala

Alur verifikasi:
1. Pustakawan/Kepala melihat daftar pengajuan dengan status `menunggu`
2. Dapat melihat detail pengajuan (buku yang diminta, data anggota)
3. **Setujui:** 
   - Sistem memvalidasi ulang ketersediaan eksemplar
   - Status peminjaman berubah menjadi `dipinjam`
   - Status eksemplar berubah menjadi `dipinjam`
   - Tanggal pinjam dan jatuh tempo diisi saat persetujuan
   - Notifikasi WhatsApp "disetujui" dikirim ke anggota
4. **Tolak:**
   - Pustakawan wajib mengisi alasan penolakan (min. 5 karakter)
   - Status peminjaman berubah menjadi `ditolak`
   - Eksemplar tetap berstatus `tersedia`
   - Notifikasi WhatsApp "ditolak" beserta alasan dikirim ke anggota

---

### 4.6 Modul Pengembalian Buku

#### FR-13: Proses Pengembalian

Alur pengembalian (hanya pustakawan):
1. Pustakawan mencari peminjaman aktif berdasarkan kode transaksi atau nama anggota
2. Filter tersedia: semua / terlambat / belum terlambat
3. Pustakawan membuka formulir pengembalian untuk transaksi yang dipilih
4. Untuk setiap eksemplar, pustakawan mencatat kondisi pengembalian:
   - `baik` → tidak ada denda kondisi
   - `rusak` → denda kerusakan dikenakan
   - `hilang` → denda kehilangan dikenakan
5. Sistem menghitung denda secara otomatis (real-time):
   - **Denda Keterlambatan** = Jumlah hari terlambat × Jumlah buku × Tarif/hari
   - **Denda Kerusakan** = Tarif kerusakan per buku yang rusak
   - **Denda Kehilangan** = Tarif kehilangan per buku yang hilang
   - **Total Denda** = Denda Keterlambatan + Denda Kerusakan + Denda Kehilangan
6. Status eksemplar diperbarui (baik → `tersedia`, rusak → `rusak`, hilang → `hilang`)
7. Status peminjaman berubah menjadi `kembali`
8. Status pembayaran diatur: jika ada denda → `belum_dibayar`, jika tidak ada → `sudah_dibayar`
9. Log aktivitas dicatat
10. Notifikasi WhatsApp pengembalian dikirim ke anggota

#### FR-14: Pencatatan Pembayaran Denda

- Pustakawan dapat menandai denda sebagai "Sudah Dibayar" dari halaman pengembalian
- Tanggal pembayaran dicatat secara otomatis

---

### 4.7 Modul Portal Anggota

#### FR-15: Katalog Buku

- Anggota dapat browsing semua buku yang tersedia dalam koleksi
- Filter berdasarkan kategori
- Pencarian berdasarkan judul buku
- Tampilan grid dengan informasi: judul, pengarang, kategori, dan ketersediaan eksemplar
- Anggota dapat memilih eksemplar yang ingin dipinjam

#### FR-16: Riwayat Peminjaman Anggota

- Anggota dapat melihat seluruh riwayat transaksi peminjaman (semua status)
- Anggota dapat melihat status pengajuan yang sedang menunggu verifikasi
- Anggota dapat melihat jumlah buku yang sedang dipinjam dan buku yang terlambat

#### FR-17: Profil Anggota

- Anggota dapat melihat data profil diri
- Anggota dapat mengubah password akun

---

### 4.8 Modul Laporan Manajerial

Laporan dapat difilter berdasarkan rentang tanggal yang fleksibel.

#### FR-18: Laporan Peminjaman & Pengembalian

- **Top 10 Buku Terpopuler:** Buku yang paling sering dipinjam dalam periode tertentu (beserta pengarang, penerbit, total peminjaman)
- **Tingkat Keterlambatan:** Persentase peminjaman yang terlambat dikembalikan
- **Tren Peminjaman Bulanan:** Grafik line chart tren 6 bulan terakhir

#### FR-19: Statistik Keanggotaan

- Total anggota (breakdown guru & siswa)
- Jumlah anggota aktif (pernah meminjam dalam periode)
- Jumlah anggota baru dalam periode
- Top 5 anggota paling aktif (paling banyak meminjam)

#### FR-20: Manajemen Inventaris/Koleksi

- Total judul buku dan total eksemplar
- Jumlah buku baru ditambahkan dalam periode
- Status eksemplar (tersedia, dipinjam, rusak, hilang) dengan persentase
- Distribusi koleksi per kategori
- Grafik: Doughnut status eksemplar, Pie chart distribusi kategori

#### FR-21: Analisis Kebutuhan Koleksi

- Analisis rasio demand vs. jumlah koleksi per kategori
- Level demand per kategori: Tinggi (≥5 pinjam/buku), Sedang (≥2), Rendah (<2)
- Rekomendasi pembelian buku: kategori dengan demand tinggi namun koleksi <10 judul

---

### 4.9 Modul Notifikasi WhatsApp

#### FR-22: Notifikasi Otomatis via WhatsApp (Fonnte API)

Notifikasi dikirim ke nomor HP anggota pada kejadian berikut:

| Kejadian | Penerima | Isi Pesan |
|---|---|---|
| Peminjaman diproses (langsung) | Anggota | Detail buku dipinjam + tanggal jatuh tempo |
| Pengajuan disetujui | Anggota | Detail buku disetujui + tanggal jatuh tempo |
| Pengajuan ditolak | Anggota | Alasan penolakan |
| Pengembalian diproses | Anggota | Detail buku dikembalikan + rincian denda |

Konfigurasi:
- Token API Fonnte dapat dikonfigurasi melalui halaman Pengaturan
- Jika anggota tidak memiliki nomor HP, notifikasi WA dilewati tanpa error

---

### 4.10 Modul Pengaturan Sistem

#### FR-23: Konfigurasi Parameter Sistem

Parameter yang dapat dikonfigurasi oleh pustakawan:

| Parameter | Default | Keterangan |
|---|---|---|
| `durasi_peminjaman_hari` | 7 hari | Durasi maksimum peminjaman |
| `max_buku_per_peminjaman` | 3 buku | Jumlah buku maks per transaksi |
| `denda_per_hari` | Rp 1.000 | Denda keterlambatan per hari per buku |
| `denda_rusak` | Rp 50.000 | Denda buku rusak |
| `denda_hilang` | Rp 100.000 | Denda buku hilang |
| `fonnte_token` | - | Token API WhatsApp (Fonnte) |
| Email settings | - | Konfigurasi pengiriman email |
| Informasi sekolah | - | Nama sekolah, alamat, logo, dsb. |

---

### 4.11 Modul Manajemen Pengguna Admin

#### FR-24: Manajemen User Admin

- CRUD untuk akun pengguna admin (kepala & pustakawan)
- Setiap user memiliki: nama, email, password, peran (role), foto profil
- Pustakawan dapat mengubah data dan password pengguna admin lain
- Profil pengguna dapat diubah oleh masing-masing user

---

### 4.12 Fitur Log Aktivitas

#### FR-25: Pencatatan Log Aktivitas

- Setiap aktivitas pengembalian dicatat ke log aktivitas sistem
- Log menyimpan: ID user, deskripsi aktivitas, waktu kejadian
- Berguna untuk audit trail perpustakaan

---

## 5. Kebutuhan Non-Fungsional

### 5.1 Performa

| Aspek | Target |
|---|---|
| Waktu muat halaman dashboard | < 3 detik |
| Waktu respons pencarian | < 1 detik |
| Caching pengaturan sistem | 5 menit (300 detik) |
| Paginasi daftar data | 10–15 item per halaman |

### 5.2 Keamanan

- Autentikasi terpisah antara admin (guard: `web`) dan anggota (guard: `anggota`)
- Proteksi CSRF pada semua form
- Validasi input pada semua operasi CRUD
- Kontrol akses berbasis peran (RBAC) pada setiap halaman
- Password di-hash menggunakan bcrypt
- Remember token untuk persistensi sesi yang aman

### 5.3 Keandalan

- Semua operasi database (peminjaman, pengembalian) menggunakan database transaction untuk menjamin konsistensi data
- Rollback otomatis jika terjadi kegagalan di tengah proses
- Penanganan error graceful dengan pesan yang informatif
- Log error untuk debugging (Laravel Log facade)

### 5.4 Kemudahan Penggunaan

- Antarmuka responsif berbasis Bootstrap
- Komponen reaktif real-time menggunakan Livewire 3 (tanpa reload halaman)
- Pencarian instan dengan filter multi-kolom
- Konfirmasi dialog untuk operasi irreversible (hapus, tolak pengajuan)
- Flash message untuk feedback setiap operasi

### 5.5 Skalabilitas

- Indeks database pada kolom yang sering di-query (foreign key, status, tanggal)
- Lazy loading data dengan paginasi
- Pembatasan hasil query saat tidak ada filter (maks. 100 record)

---

## 6. Arsitektur Teknis

### 6.1 Stack Teknologi

| Layer | Teknologi |
|---|---|
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend Reaktif** | Livewire 3.6+ |
| **Database** | SQLite (development) / MySQL (production) |
| **Build Tool** | Vite.js |
| **Notifikasi WA** | Fonnte API (HTTP) |
| **Templating** | Blade + Bootstrap |
| **Caching** | Laravel Cache (file-based) |
| **Queue** | Laravel Queue (database driver) |

### 6.2 Struktur Database

#### Tabel Utama

```
users           → Pengguna admin sistem (pustakawan, kepala)
anggota         → Anggota perpustakaan (siswa, guru) 
kategori        → Kategori/klasifikasi buku
buku            → Master data buku
eksemplar       → Eksemplar fisik setiap buku
peminjaman      → Transaksi peminjaman
detail_peminjaman → Detail buku per transaksi peminjaman
pengaturan      → Konfigurasi sistem (key-value store)
log_aktivitas   → Log aktivitas pengguna
```

#### Relasi Utama

```
users           1 ←→ N  peminjaman
anggota         1 ←→ N  peminjaman
peminjaman      1 ←→ N  detail_peminjaman
buku            1 ←→ N  eksemplar
kategori        1 ←→ N  buku
eksemplar       1 ←→ N  detail_peminjaman
```

### 6.3 Status State Machine

#### Status Peminjaman (`status_buku`)

```
[Pengajuan Anggota]
    menunggu → dipinjam (disetujui pustakawan)
    menunggu → ditolak  (ditolak pustakawan)

[Peminjaman Langsung]
    (langsung) → dipinjam

[Pengembalian]
    dipinjam → kembali
```

#### Status Eksemplar (`status_eksemplar`)

```
tersedia → dipinjam   (saat peminjaman disetujui/dilakukan)
dipinjam → tersedia   (saat dikembalikan dalam kondisi baik)
dipinjam → rusak      (saat dikembalikan dalam kondisi rusak)
dipinjam → hilang     (saat dinyatakan hilang)
```

---

## 7. Komponen Livewire

| Komponen | Fungsi |
|---|---|
| `HomeComponent` | Dashboard statistik dan grafik admin |
| `AnggotaComponent` | CRUD manajemen anggota |
| `BukuComponent` | CRUD manajemen buku |
| `EksemplarComponent` | CRUD manajemen eksemplar |
| `KategoriComponent` | CRUD manajemen kategori |
| `PeminjamanComponent` | Transaksi peminjaman langsung |
| `PengembalianComponent` | Proses pengembalian dan denda |
| `VerifikasiPengajuanComponent` | Verifikasi pengajuan dari anggota |
| `LaporanComponent` | Laporan dan analisis manajerial |
| `UserComponent` | Manajemen user admin |
| `PengaturanComponent` | Konfigurasi sistem |
| `ProfilComponent` | Profil user admin |
| `AnggotaKatalogComponent` | Portal anggota (katalog + pengajuan) |
| `AnggotaProfilComponent` | Profil anggota |
| `HistoryPeminjamanComponent` | Riwayat peminjaman anggota |
| `HistoryPengembalianComponent` | Riwayat pengembalian anggota |
| `UnifiedLoginComponent` | Halaman login terpadu |

---

## 8. Aturan Bisnis Utama

| ID | Aturan |
|---|---|
| BR-01 | Anggota tidak dapat melakukan/mengajukan peminjaman baru jika masih memiliki peminjaman aktif |
| BR-02 | Anggota tidak dapat mengajukan baru jika ada pengajuan yang sedang menunggu verifikasi |
| BR-03 | Jumlah buku per transaksi dibatasi oleh pengaturan (default: maks. 3 buku) |
| BR-04 | Tidak boleh meminjam 2 eksemplar dari judul buku yang sama dalam 1 transaksi |
| BR-05 | Durasi peminjaman tidak boleh melebihi pengaturan durasi maksimum |
| BR-06 | Peminjaman yang masih aktif (`dipinjam`) tidak dapat dihapus |
| BR-07 | Denda keterlambatan dihitung per hari per buku sejak jatuh tempo |
| BR-08 | Saat pengajuan anggota disetujui, ketersediaan eksemplar divalidasi ulang |
| BR-09 | Eksemplar yang pengajuannya belum disetujui tidak dikunci (tetap `tersedia`) |
| BR-10 | Notifikasi WA hanya dikirim jika anggota memiliki nomor HP |

---

## 9. Tampilan dan Pengalaman Pengguna

### 9.1 Tata Letak

- **Admin:** Layout sidebar navigasi + area konten utama + header dengan info user
- **Anggota:** Layout portal yang lebih sederhana dengan header navigasi

### 9.2 Tema Antarmuka

- Desain modern berbasis Bootstrap
- Komponen reaktif (modal, form, tabel) tanpa reload halaman (Livewire)
- Indikator loading saat proses background
- Responsive untuk layar desktop dan tablet

### 9.3 Feedback Pengguna

- Flash message (success/error/info) pada setiap operasi
- Validasi form real-time
- Konfirmasi dialog untuk aksi berbahaya
- Struk/bukti peminjaman yang dapat dicetak

---

## 10. Kriteria Penerimaan (Acceptance Criteria)

### 10.1 Modul Peminjaman

- ✅ Pustakawan dapat mencatat peminjaman dalam < 30 detik
- ✅ Kode transaksi unik dibuat otomatis dengan format yang benar
- ✅ Sistem menolak peminjaman jika anggota masih memiliki buku aktif
- ✅ Struk dapat ditampilkan dan dicetak browser

### 10.2 Modul Pengembalian

- ✅ Denda dihitung otomatis dan akurat berdasarkan tanggal kembali aktual
- ✅ Status eksemplar diperbarui dengan benar sesuai kondisi
- ✅ Notifikasi WA terkirim ke anggota

### 10.3 Portal Anggota

- ✅ Anggota dapat mengajukan peminjaman tanpa bantuan pustakawan
- ✅ Anggota dapat melihat status pengajuannya secara real-time
- ✅ Anggota menerima notifikasi WA saat pengajuan diproses

### 10.4 Laporan

- ✅ Semua laporan dapat difilter berdasarkan rentang tanggal
- ✅ Grafik ditampilkan dengan data akurat
- ✅ Rekomendasi kebutuhan koleksi menghasilkan insight yang relevan

---

## 11. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Notifikasi WA gagal terkirim | Anggota tidak mendapat info peminjaman | Error ditangani secara graceful, operasi tetap berhasil, error dilog |
| Eksemplar habis saat verifikasi | Pengajuan tidak bisa disetujui | Validasi ulang saat approval, pesan error informatif |
| Race condition pengajuan ganda | Data tidak konsisten | Eksemplar baru dikunci setelah persetujuan, bukan saat pengajuan |
| Database tidak konsisten | Data corrupt | Semua operasi kritis dalam database transaction |
| Pengaturan tidak terkonfigurasi | Sistem pakai nilai default | Semua parameter memiliki nilai default yang aman |

---

## 12. Glosarium

| Istilah | Definisi |
|---|---|
| **Anggota** | Pengguna perpustakaan (siswa/guru) yang terdaftar |
| **Eksemplar** | Satu unit fisik buku (satu judul buku dapat memiliki banyak eksemplar) |
| **Peminjaman** | Transaksi pencatatan buku yang dipinjam oleh anggota |
| **Pengajuan** | Permintaan peminjaman yang diajukan anggota dan menunggu verifikasi |
| **Jatuh Tempo** | Tanggal batas waktu pengembalian buku |
| **Denda** | Biaya yang dikenakan atas keterlambatan, kerusakan, atau kehilangan buku |
| **Kode Transaksi** | Identifikasi unik setiap transaksi peminjaman (format: PJM-YYYYMMDD-XXXX) |
| **No. Panggil** | Kode klasifikasi buku untuk penempatan di rak (call number) |
| **RBAC** | Role-Based Access Control – sistem hak akses berbasis peran |
| **Fonnte** | Layanan API pihak ketiga untuk pengiriman pesan WhatsApp |

---

*Dokumen ini merupakan spesifikasi kebutuhan produk untuk Sistem Informasi Manajemen Perpustakaan Sekolah Dasar (SIMPS-SD). Versi selanjutnya dari dokumen ini akan memperbarui spesifikasi sesuai dengan perkembangan sistem.*
