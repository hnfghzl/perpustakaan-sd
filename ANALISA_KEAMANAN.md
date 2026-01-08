# ANALISA KEAMANAN & VALIDASI INPUT

**Tanggal**: 2 Januari 2026  
**Project**: Sistem Perpustakaan Laravel 12 + Livewire 3  
**Scope**: Security audit semua komponen Livewire, validasi input, RBAC, dan XSS protection

---

## 🔐 EXECUTIVE SUMMARY

### Status Keamanan Umum: ⚠️ **BAIK DENGAN BEBERAPA PERBAIKAN MINOR**

**Temuan Positif:**

-   ✅ SQL Injection: **AMAN** (menggunakan Eloquent ORM & parameter binding)
-   ✅ Password Security: **AMAN** (Hash::make() dengan bcrypt)
-   ✅ RBAC Implementation: **LENGKAP** (role guard di setiap component)
-   ✅ CSRF Protection: **AKTIF** (Laravel default + Livewire)
-   ✅ Session Management: **AMAN** (regenerate() setelah login)

**Temuan yang Perlu Perbaikan:**

-   ⚠️ XSS Protection: Beberapa output tidak di-escape
-   ⚠️ Authorization: Beberapa method tidak cek ownership
-   ⚠️ File Upload: Validasi terbatas (ProfilComponent)
-   ⚠️ Email Configuration: Password disimpan plain text di database & .env
-   ⚠️ Rate Limiting: Tidak ada throttling untuk login dan form submission

---

## 📊 VULNERABILITY ASSESSMENT BY CATEGORY

### 1. SQL INJECTION PROTECTION ✅ AMAN

**Status**: Semua query menggunakan Eloquent ORM dengan parameter binding otomatis.

**Evidence**:

```php
// AMAN - Eloquent ORM
Anggota::where('nama_anggota', 'like', '%' . $this->search . '%')->get();

// AMAN - Mass assignment dengan $fillable/$guarded
User::create([
    'nama_user' => $this->nama_user,
    'email' => $this->email
]);

// AMAN - Query Builder dengan binding
DetailPeminjaman::whereIn('id_peminjaman', $selectedIds)->update([...]);
```

**Kesimpulan**: Tidak ada raw query atau string concatenation untuk SQL, semuanya melalui Eloquent.

---

### 2. XSS (CROSS-SITE SCRIPTING) ⚠️ PERLU PERBAIKAN

**Masalah yang Ditemukan**:

#### 2.1. Output Tidak Di-Escape di View (CRITICAL)

**Lokasi**: Semua view Blade yang menampilkan data user-submitted

**Contoh Vulnerable**:

```blade
<!-- AnggotaComponent View -->
<td>{{ $anggota->nama_anggota }}</td>  <!-- Vulnerable jika ada <script> -->
<td>{{ $anggota->alamat }}</td>       <!-- Vulnerable -->

<!-- PeminjamanComponent View -->
<td>{{ $peminjaman->anggota->nama_anggota }}</td>

<!-- BukuComponent View -->
<td>{{ $buku->judul }}</td>           <!-- Vulnerable -->
```

**Risk**: Jika user memasukkan nama anggota seperti `<script>alert('XSS')</script>`, akan dieksekusi.

**Rekomendasi**:
Laravel Blade secara default sudah escape `{{ }}`, tapi pastikan:

1. JANGAN gunakan `{!! !!}` untuk data user-submitted
2. Gunakan `{{ e($variable) }}` untuk extra safety
3. Sanitasi input di component sebelum save:

```php
// Di AnggotaComponent::store()
$this->validate([
    'nama_anggota' => 'required|string|max:255',
    'alamat' => 'nullable|string|max:500'
]);

// Tambahkan sanitasi
use Illuminate\Support\Str;

$this->nama_anggota = Str::limit(strip_tags($this->nama_anggota), 255);
$this->alamat = Str::limit(strip_tags($this->alamat), 500);
```

#### 2.2. Deskripsi Kategori (MEDIUM)

**Lokasi**: `KategoriComponent`

```php
// Field deskripsi bisa berisi HTML
'deskripsi' => 'nullable|max:500'
```

**Rekomendasi**: Strip HTML tags atau gunakan HTML purifier.

#### 2.3. Flash Messages (LOW)

**Lokasi**: Semua component

```php
session()->flash('error', 'Gagal: ' . $e->getMessage());
```

**Risk**: Exception message bisa contain user input.

**Rekomendasi**:

```php
session()->flash('error', 'Gagal menyimpan data. Silakan coba lagi.');
Log::error('Detail error', ['message' => $e->getMessage()]);
```

---

### 3. AUTHORIZATION & RBAC ⚠️ PERLU PERBAIKAN

**Status**: RBAC sudah diimplementasi tapi ada beberapa gap.

#### 3.1. Role-Based Access Control (RBAC) ✅ BAIK

**Implementation Pattern**:

```php
// Mount Guard - Ada di semua component
public function mount() {
    if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
        session()->flash('error', 'Anda tidak memiliki akses!');
        return redirect()->route('home');
    }
}
```

**Role Matrix**:
| Feature | Pustakawan | Kepala |
|---------|-----------|--------|
| View Dashboard | ✅ | ✅ |
| CRUD Anggota | ✅ | 👁️ Read-only |
| CRUD Buku | ✅ | 👁️ Read-only |
| CRUD Eksemplar | ✅ | 👁️ Read-only |
| CRUD Kategori | ✅ | 👁️ Read-only |
| Peminjaman | ✅ | ❌ No Access |
| Pengembalian | ✅ | ❌ No Access |
| User Management | 👤 Self-edit | ✅ Full |
| Pengaturan | ✅ | ✅ |
| Laporan | ✅ | ✅ |

#### 3.2. Missing Authorization Checks (CRITICAL)

**Issue 1: AnggotaComponent::deleteNow()** - TIDAK ADA CEK ROLE

```php
#[On('deleteAnggota')]
public function deleteNow($id) {
    $anggota = Anggota::find($id);
    if ($anggota) {
        $anggota->delete();
    }
}
```

**Risk**: Kepala bisa hapus anggota meskipun UI-nya hidden (bisa dipanggil via browser console).

**Fix**:

```php
#[On('deleteAnggota')]
public function deleteNow($id) {
    // CRITICAL: Add role check
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin menghapus anggota!');
        return;
    }

    $anggota = Anggota::find($id);
    if ($anggota) {
        $anggota->delete();
        session()->flash('success', 'Anggota berhasil dihapus!');
    }
}
```

**Issue 2: BukuComponent::destroy()** - TIDAK ADA CEK ROLE

```php
public function destroy($id) {
    // Missing authorization check!
}
```

**Issue 3: KategoriComponent::destroy()** - TIDAK ADA CEK ROLE

```php
public function destroy($id) {
    DB::beginTransaction();
    try {
        $kategori = Kategori::withCount('buku')->find($id);
        // ... no role check
    }
}
```

**Issue 4: EksemplarComponent::destroy()** - TIDAK ADA CEK ROLE

```php
public function destroy($id) {
    // Missing authorization check!
}
```

**Rekomendasi**: Tambahkan role guard di semua CRUD methods:

```php
public function store() {
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin!');
        return;
    }
    // ... rest of code
}

public function update() {
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin!');
        return;
    }
    // ... rest of code
}

public function destroy($id) {
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin!');
        return;
    }
    // ... rest of code
}
```

#### 3.3. Ownership Validation (MEDIUM)

**Issue**: ProfilComponent tidak cek ownership saat update foto

```php
public function updateProfil() {
    // User bisa ubah profil user lain via browser console manipulation
    $user = User::find(Auth::id()); // Baik, pakai Auth::id()

    // Tapi jika ada manipulasi ID di request, tidak ada validasi
}
```

**Rekomendasi**: Sudah aman karena pakai `Auth::id()` hardcoded.

---

### 4. PASSWORD & CREDENTIAL MANAGEMENT ⚠️ PERLU PERBAIKAN

#### 4.1. Password Hashing ✅ AMAN

**Implementation**:

```php
// UserComponent::store()
User::create([
    'password' => Hash::make($this->password) // bcrypt
]);

// ProfilComponent::updatePassword()
if (!Hash::check($this->current_password, $user->password)) {
    session()->flash('error', 'Password lama tidak sesuai!');
    return;
}
```

**Kesimpulan**: Menggunakan bcrypt via `Hash::make()`, sudah aman.

#### 4.2. Email Password Storage (CRITICAL)

**Issue**: Password email SMTP disimpan **PLAIN TEXT** di:

1. **Database** (`pengaturan.email_password`)
2. **.env file** (`MAIL_PASSWORD`)

**Lokasi**: `PengaturanComponent::simpan()`

```php
// Password disimpan tanpa enkripsi
Pengaturan::set('email_password', $value); // Plain text di DB!

// Ditulis ke .env tanpa enkripsi
$envContent = preg_replace($pattern, "MAIL_PASSWORD={$value}", $envContent);
```

**Risk**:

-   Database compromise → email credentials leaked
-   `.env` file accessible → credentials leaked
-   Insider threat → developer bisa lihat password

**Rekomendasi**:

1. **Enkripsi password di database**:

```php
use Illuminate\Support\Facades\Crypt;

// Saat simpan
Pengaturan::set('email_password', Crypt::encryptString($this->pengaturan['email_password']));

// Saat load
$emailPassword = Crypt::decryptString(Pengaturan::get('email_password'));
```

2. **Jangan tulis ke .env**, load dari database saja
3. **Gunakan environment variable injection** untuk production (AWS Secrets Manager, Azure Key Vault)

#### 4.3. Password Complexity (MEDIUM)

**Issue**: Password hanya butuh minimal 6 karakter

```php
// UserComponent & ProfilComponent
'password' => 'required|min:6'
```

**Rekomendasi**: Tambah complexity rules:

```php
'password' => [
    'required',
    'min:8',
    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/' // Minimal 1 huruf besar, kecil, dan angka
],
'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka!'
```

#### 4.4. Password Reset (MISSING)

**Issue**: Tidak ada mekanisme password reset jika lupa password.

**Rekomendasi**: Implementasi Laravel's built-in password reset:

```bash
php artisan make:auth
```

---

### 5. FILE UPLOAD SECURITY ⚠️ PERLU PERBAIKAN

**Lokasi**: `ProfilComponent::updateProfil()`

```php
$this->validate([
    'foto_profil' => 'nullable|image|max:2048' // 2MB
]);

// Upload handling
$filename = 'profil_' . Auth::id() . '_' . time() . '.' . $this->foto_profil->extension();
$path = $this->foto_profil->storeAs('foto_profil', $filename, 'public');
```

**Issues**:

#### 5.1. MIME Type Bypass (MEDIUM)

**Risk**: Attacker bisa rename `shell.php.jpg` dan bypass validation.

**Fix**:

```php
$this->validate([
    'foto_profil' => [
        'nullable',
        'image',
        'mimes:jpeg,png,jpg', // Eksplisit MIME types
        'max:2048',
        // Custom validation
        function ($attribute, $value, $fail) {
            $mimeType = $value->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimes)) {
                $fail('File harus berupa gambar JPG/PNG!');
            }
        }
    ]
]);
```

#### 5.2. Filename Sanitization (LOW)

**Current**: Filename sudah aman karena pakai `time()` dan `Auth::id()`.

**Rekomendasi**: Tambah random hash untuk uniqueness:

```php
$filename = 'profil_' . Auth::id() . '_' . Str::random(10) . '.jpg';
```

#### 5.3. Old File Deletion (GOOD ✅)

```php
if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
    Storage::disk('public')->delete($user->foto_profil);
}
```

**Kesimpulan**: Sudah ada cleanup file lama.

---

### 6. SESSION & AUTHENTICATION ✅ AMAN

#### 6.1. Login Process (GOOD)

```php
// LoginComponent::proses()
if (Auth::attempt($credentials)) {
    session()->regenerate(); // Prevent session fixation ✅
    return redirect()->route('home');
}
```

#### 6.2. Logout Process (GOOD)

```php
public function keluar() {
    Auth::logout();
    session()->invalidate();         // ✅
    session()->regenerateToken();    // ✅ CSRF token refresh
    return redirect()->route('login');
}
```

**Kesimpulan**: Session management sudah aman.

---

### 7. INPUT VALIDATION ⚠️ PERLU PERBAIKAN

#### 7.1. Validasi Email ✅ BAIK

```php
'email' => 'required|email|unique:anggota,email'
```

#### 7.2. Enum Validation ✅ BAIK

```php
'jenis_anggota' => 'required|in:guru,siswa',
'status_eksemplar' => 'required|in:tersedia,hilang,rusak',
'kondisi_kembali' => 'required|in:baik,rusak,hilang'
```

#### 7.3. Date Validation ⚠️ PERLU PERBAIKAN

**Issue**: Tidak ada validasi past/future date

**Lokasi**: `PeminjamanComponent::store()`

```php
'tgl_pinjam' => 'required|date',
'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam'
```

**Problem**: User bisa input tanggal pinjam 10 tahun lalu.

**Fix**:

```php
'tgl_pinjam' => 'required|date|before_or_equal:today',
'tgl_kembali' => 'required|date|before_or_equal:today|after_or_equal:tgl_pinjam'
```

#### 7.4. Integer Validation ✅ BAIK

```php
'jumlah_eksemplar' => 'required|integer|min:1|max:50',
'harga' => 'nullable|numeric|min:0'
```

#### 7.5. String Length ✅ BAIK

```php
'judul' => 'required|string|max:255',
'deskripsi' => 'nullable|max:500'
```

---

### 8. RATE LIMITING ⚠️ MISSING (CRITICAL)

**Issue**: Tidak ada throttling untuk:

1. Login attempts (brute force attack)
2. Form submissions (spam)
3. API calls (jika ada)

**Rekomendasi**:

#### 8.1. Login Rate Limiting

**File**: `app/Livewire/LoginComponent.php`

```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

public function proses()
{
    // Throttle login by email (5 attempts per minute)
    $key = 'login-' . $this->email . '-' . request()->ip();

    if (RateLimiter::tooManyAttempts($key, 5)) {
        $seconds = RateLimiter::availableIn($key);
        session()->flash('error', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.");
        return;
    }

    $credentials = $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        RateLimiter::clear($key); // Clear on success
        session()->regenerate();
        return redirect()->route('home');
    }

    RateLimiter::hit($key, 60); // Increment on failure, 60 seconds decay
    session()->flash('error', 'Email atau password salah!');
}
```

#### 8.2. Form Submission Rate Limiting

**Apply to**: AnggotaComponent, BukuComponent, PeminjamanComponent

```php
public function store()
{
    $key = 'form-submit-' . Auth::id();

    if (RateLimiter::tooManyAttempts($key, 10)) { // 10 submissions per minute
        session()->flash('error', 'Terlalu cepat! Tunggu sebentar.');
        return;
    }

    RateLimiter::hit($key, 60);

    // ... rest of code
}
```

---

### 9. LOGGING & MONITORING ⚠️ PERLU PERBAIKAN

#### 9.1. Sensitive Data in Logs (CRITICAL)

**Issue**: Password dan kredensial ter-log

```php
// PengaturanComponent::simpan()
Log::info('Pengaturan diubah', ['data' => $this->pengaturan]);
// ⚠️ email_password ter-log dalam plain text!
```

**Fix**:

```php
$safeData = $this->pengaturan;
unset($safeData['email_password']); // Remove sensitive data
Log::info('Pengaturan diubah', ['data' => $safeData]);
```

#### 9.2. Exception Logging ✅ BAIK

```php
Log::error('Gagal', [
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString()
]);
```

#### 9.3. Audit Trail (PARTIAL)

**Current**: Hanya `LogAktivitas` untuk peminjaman/pengembalian

**Rekomendasi**: Tambahkan audit log untuk:

-   User login/logout
-   CRUD operations pada data sensitif
-   Permission changes
-   Configuration changes

---

### 10. TRANSACTION INTEGRITY ✅ BAIK

**Implementation**: Menggunakan DB transaction untuk atomic operations

```php
// PeminjamanComponent::store()
DB::beginTransaction();
try {
    // Create peminjaman
    // Create detail_peminjaman
    // Update status eksemplar
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Peminjaman gagal', ['error' => $e->getMessage()]);
}
```

**Kesimpulan**: Transaction handling sudah baik, ACID compliance terjaga.

---

## 🔧 REKOMENDASI PERBAIKAN

### Priority 1: CRITICAL (Segera Diperbaiki)

1. **Tambahkan Authorization Check di semua CRUD methods**

    - AnggotaComponent::deleteNow()
    - BukuComponent::destroy()
    - KategoriComponent::destroy()
    - EksemplarComponent::destroy()

2. **Enkripsi Email Password di Database**

    - Gunakan `Crypt::encryptString()` untuk `email_password`
    - Update AppServiceProvider untuk decrypt

3. **Implement Rate Limiting untuk Login**

    - Prevent brute force attack
    - Max 5 attempts per minute

4. **Remove Sensitive Data from Logs**
    - Jangan log password dan credentials
    - Filter sensitive keys sebelum logging

### Priority 2: HIGH (Dalam 1 Minggu)

5. **Sanitasi Input untuk XSS Prevention**

    - Strip HTML tags di semua user input
    - Use `strip_tags()` atau HTML Purifier

6. **Password Complexity Rules**

    - Min 8 karakter
    - Harus ada huruf besar, kecil, dan angka

7. **Date Validation Enhancement**

    - `tgl_pinjam` tidak boleh masa depan
    - `tgl_kembali` tidak boleh masa depan

8. **File Upload MIME Type Validation**
    - Validasi MIME type secara eksplisit
    - Cek magic bytes selain extension

### Priority 3: MEDIUM (Dalam 1 Bulan)

9. **Implement Password Reset Feature**

    - Laravel's built-in password reset
    - Email verification

10. **Form Submission Rate Limiting**

    - Throttle CRUD operations
    - 10 submissions per minute

11. **Comprehensive Audit Trail**

    - Log semua CRUD operations
    - Log permission changes

12. **Environment Variable Security**
    - Jangan tulis credentials ke .env
    - Gunakan secret management (AWS Secrets Manager)

---

## 📝 SECURITY CHECKLIST

### Authentication ✅

-   [x] Password hashing (bcrypt)
-   [x] Session regeneration after login
-   [x] Session invalidation on logout
-   [x] CSRF token regeneration on logout
-   [ ] Rate limiting on login (MISSING)
-   [ ] Password reset feature (MISSING)
-   [ ] Two-factor authentication (NOT IMPLEMENTED)

### Authorization ✅

-   [x] RBAC implementation (role-based)
-   [x] Mount guards di semua component
-   [ ] Authorization check di semua CRUD methods (PARTIAL)
-   [x] Ownership validation (self-edit only)

### Input Validation ✅

-   [x] Email validation
-   [x] Enum validation
-   [x] Integer/numeric validation
-   [x] String length validation
-   [ ] HTML/Script tag sanitization (MISSING)
-   [ ] Date boundary validation (PARTIAL)

### SQL Injection ✅

-   [x] Eloquent ORM usage
-   [x] Parameter binding
-   [x] No raw queries

### XSS Protection ⚠️

-   [x] Blade auto-escaping
-   [ ] Input sanitization (MISSING)
-   [ ] Content Security Policy (NOT IMPLEMENTED)

### File Upload ⚠️

-   [x] File type validation
-   [ ] MIME type validation (PARTIAL)
-   [x] File size limit
-   [x] Unique filename generation
-   [x] Old file cleanup

### Session Management ✅

-   [x] Session regeneration
-   [x] Session invalidation
-   [x] CSRF protection (Laravel default)

### Logging ⚠️

-   [x] Exception logging
-   [ ] Sensitive data filtering (MISSING)
-   [ ] Comprehensive audit trail (PARTIAL)

### Rate Limiting ❌

-   [ ] Login throttling (MISSING)
-   [ ] Form submission throttling (MISSING)
-   [ ] API rate limiting (N/A)

### Data Protection ⚠️

-   [ ] Email password encryption (MISSING - CRITICAL)
-   [x] User password hashing
-   [ ] Database encryption at rest (NOT CONFIGURED)

---

## 🎯 SKOR KEAMANAN

| Kategori                 | Skor  | Status               |
| ------------------------ | ----- | -------------------- |
| SQL Injection Protection | 10/10 | ✅ Excellent         |
| Password Security        | 7/10  | ⚠️ Good              |
| RBAC & Authorization     | 6/10  | ⚠️ Needs Improvement |
| XSS Protection           | 5/10  | ⚠️ Needs Improvement |
| Session Management       | 10/10 | ✅ Excellent         |
| Input Validation         | 7/10  | ⚠️ Good              |
| File Upload Security     | 6/10  | ⚠️ Needs Improvement |
| Rate Limiting            | 0/10  | ❌ Missing           |
| Logging & Monitoring     | 5/10  | ⚠️ Needs Improvement |
| Transaction Integrity    | 10/10 | ✅ Excellent         |

**Overall Security Score**: **66/100** (⚠️ **MODERATE RISK**)

---

## 📅 IMPLEMENTATION ROADMAP

### Week 1: Critical Fixes

-   [ ] Authorization checks di CRUD methods (2 hari)
-   [ ] Email password encryption (1 hari)
-   [ ] Login rate limiting (1 hari)
-   [ ] Remove sensitive data from logs (1 hari)

### Week 2: High Priority

-   [ ] XSS input sanitization (2 hari)
-   [ ] Password complexity rules (1 hari)
-   [ ] Date validation enhancement (1 hari)
-   [ ] File upload MIME validation (1 hari)

### Week 3-4: Medium Priority

-   [ ] Password reset feature (3 hari)
-   [ ] Form submission rate limiting (2 hari)
-   [ ] Comprehensive audit trail (3 hari)
-   [ ] Security testing & penetration test (2 hari)

---

## 🧪 TESTING RECOMMENDATIONS

### Security Testing Checklist

1. **SQL Injection**: Try `' OR '1'='1` di search fields
2. **XSS**: Try `<script>alert('XSS')</script>` di nama anggota
3. **CSRF**: Try form submission without CSRF token
4. **Brute Force**: Try 10 wrong logins in 1 minute
5. **Authorization Bypass**: Try delete via browser console as Kepala
6. **File Upload**: Try upload PHP shell as JPG
7. **Session Fixation**: Check session regeneration after login

### Automated Security Scanning

```bash
# Laravel Security Checker
composer require enlightn/security-checker --dev
php artisan security:check

# OWASP Dependency Check
composer audit

# Static Analysis
composer require --dev phpstan/phpstan
./vendor/bin/phpstan analyse app
```

---

## 📖 REFERENCES

-   [OWASP Top 10 2021](https://owasp.org/www-project-top-ten/)
-   [Laravel Security Best Practices](https://laravel.com/docs/12.x/security)
-   [CWE Top 25 Most Dangerous Software Weaknesses](https://cwe.mitre.org/top25/)
-   [PHP Security Best Practices](https://www.php.net/manual/en/security.php)

---

**Next Steps**: Lihat file `PERBAIKAN_KEAMANAN.md` untuk implementasi fixes secara detail.
